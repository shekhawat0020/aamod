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
	
	public function loanFields(Request $request)
    {
		$loanType = $request->loan_type;
		
		$loan_fields = LoanType::where('id', $loanType)->first()->loan_fields;
		
		$loan_fields = json_decode($loan_fields);
		$loan_fields1 = implode(',',$loan_fields);
		
		
		$fields = LoanField::whereIn('id', $loan_fields)->get();
		
		 $fields = $fields->sortBy(function ($model) use ($loan_fields) {
			return array_search($model->id, $loan_fields);
		});
		
		
        return response()->json([
            'status' => true,
            'data' => $fields
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
	
	
	
	
}
