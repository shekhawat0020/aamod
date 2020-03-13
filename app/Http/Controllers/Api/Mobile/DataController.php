<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Borrower;
use App\LoanField;
use App\LoanType;
use App\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
use URL;
class DataController extends Controller
{
    
	
	
	public function loanList(Request $request)
    {
		$loans = LoanType::where('status', 1)->get();
        return response()->json([
            'status' => true,
			'base_url' => URL::to('/').'/',
            'data' => $loans
        ]);
    }
	
	
	
	
	public function createLoanForm(Request $request)
    {
		$loanType = LoanType::where('id', $request->loan_type)->first();
		//$loanfields = json_decode($loanType->loan_fields);
		$loanfields = implode(',',json_decode($loanType->loan_fields));
		//$fields = LoanField::whereIn('id', $loanfields)->get();
		$fields = LoanField::where('status', 1)->orderByRaw("FIELD(id, $loanfields)")->get();
		//$fields = $fields->sortBy(function ($model) use ($loanfields) {
		//	return array_search($model->id, $loanfields);
		//});
		$borrowers = Borrower::where('status', 1)->get();
		
		
		
		return response()->json([
            'status' => true,
            'loanType' => $loanType,
            'fields' => $fields,
            'borrowers' => $borrowers
        ]);
		
    }
	
	
	public function saveLoanForm(Request $request)
    {
		//get loan fields
		$loanType = LoanType::where('id', $request->loan_type)->first();
		$loanfields = json_decode($loanType->loan_fields);	
		$fields = LoanField::whereIn('id', $loanfields)->get();
        
        $rules = [
			'borrower' => 'required|exists:borrower,id',
			'loan_type' => 'required|exists:loantype,id'
		];
		
		$data = $this->createRule($rules, $fields, $request);
		
		$rules = $data['rules'];
		$fields = $data['fields'];
		
		
		
        $validator = Validator::make($request->all(),  $rules);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $loan = new Loan();
        $loan->borrower_id = $request->borrower;
        $loan->loan_type_id = $request->loan_type;
        $loan->fields = json_encode($fields);
        $loan->save();


        return response()->json([
            'status' => true,
            'msg' => 'Loan created successfully'
			]);

    }


	
	
	public function borrowerLoanList(Request $request){
		
		$validator = Validator::make($request->all(), [
            'borrower_id' => 'required|exists:borrower,id',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$loans = Loan::with('assign_detail')
		->with('borrower_detail')
		->with('loan_type_detail')
		->where('borrower_id', $request->borrower_id)
		->latest()->get();
		
		return response()->json([
            'status' => true,
            'site_url' => URL::to('/').'/',
            'data' => $loans
        ]);
		
	}
	
	public function borrowerLoanDetail(Request $request){
		
		$validator = Validator::make($request->all(), [
            'loan_id' => 'required|exists:loan,id',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$loans = Loan::with('assign_detail')
		->with('borrower_detail')
		->with('loan_type_detail')
		->with('loan_type_detail')
		->with(['loan_bank' => function($query){
			
			$query->with(['loan_bank_all_status_detail' => function($q){
				
				$q->with('loan_status_detail');
				$q->with('loan_sub_status_detail');
				
			}]);
			
			
		}])
		->where('id', $request->loan_id)
		->first();
		
		return response()->json([
            'status' => true,
            'site_url' => URL::to('/').'/',
            'data' => $loans
        ]);
		
	}
	
	
	
	public function createRule($rules, $fields, $request){
		
		$input = array();
		foreach($fields as $field){
			
			$name = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', $field->title));
			$input[$name] = $request->input($name);
			if($field->field_type == 'Select'){
				$option = json_decode($field->options_value);
				$option = implode(',', $option);
				if($field->field_required){
					$rules[$name] = "required|in:".$option;
				}else{
					$rules[$name] = "nullable|in:".$option;
				}
				
				
			}
			
			else if($field->field_type == 'Text'){
				if($field->field_required){
					$rules[$name] = "required";
				}else{
					$rules[$name] = "";
				}
				
			}
			
			else if($field->field_type == 'Numeric'){
				if($field->field_required){
					$rules[$name] = "required|numeric";
				}else{
					$rules[$name] = "nullable|numeric";
				}
				
			}
			
			else if($field->field_type == 'Textarea'){
				if($field->field_required){
					$rules[$name] = "required";
				}else{
					$rules[$name] = "";
				}
				
			}
			
			else if($field->field_type == 'Date'){
				if($field->field_required){
					$rules[$name] = "required|date_format:Y-m-d";
				}else{
					$rules[$name] = "nullable|date_format:Y-m-d";
				}
				
			}
			
			else if($field->field_type == 'Mobile'){
				if($field->field_required){
					$rules[$name] = "required|min:10";
				}else{
					$rules[$name] = "nullable|min:10";
				}
				
			}
			
			else if($field->field_type == 'Email'){
				if($field->field_required){
					$rules[$name] = "required|email";
				}else{
					$rules[$name] = "nullable|email";
				}
				
			}
			
			else if($field->field_type == 'Credit Card'){
				if($field->field_required){
					$rules[$name] = "required";
				}else{
					$rules[$name] = "";
				}
				
			}
			
			else if($field->field_type == 'Aadhar'){
				if($field->field_required){
					$rules[$name] = "required";
				}else{
					$rules[$name] = "";
				}
				
			}
			
			else if($field->field_type == 'Pan'){
				if($field->field_required){
					$rules[$name] = "required";
				}else{
					$rules[$name] = "";
				}
				
			}
			
			
		}
		$data['rules'] = $rules;
		$data['fields'] = $input;
		return $data;
		
	}

	
	
	
	
}
