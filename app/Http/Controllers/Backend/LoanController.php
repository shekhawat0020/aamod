<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LoanType;
use App\Loan;
use App\LoanField;
use App\LoanStatus;
use App\LoanBank;
use App\LoanBankStatus;
use App\User;
use App\Borrower;
use App\Bank;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Loan::with('assign_detail')->with('borrower_detail')->with('loan_type_detail')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Loan Edit')){
                            $btn .= '<a href="'.route("loan-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Loan View')){
                        $btn .= ' <a href="'.route("loan-action", $row->id).'" class="edit btn btn-primary btn-sm">Action</a>';
                        }
						
						if(Auth()->user()->can('Loan Assign')){
                        $btn .= ' <button type="button" data-url="'.route('loan-assign-form', $row->id).'" class="edit btn btn-primary btn-sm assignDetail">Assign</button>';
                        }
                        return $btn;
                    })
                     ->addColumn('status',  function ($user) {
                        return ($user->status)?'Active':'InActive';
                     })
                    ->rawColumns(['action'])
                    ->make(true);
        }
      $loanTypes = LoanType::where('status', 1)->get();
        return view('admin.loan.loan',compact('loanTypes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($loan_type_id)
    {
		$loanType = LoanType::where('id', $loan_type_id)->first();
		$loanfields = json_decode($loanType->loan_fields);
		$fields = LoanField::whereIn('id', $loanfields)->get();
		$fields = $fields->sortBy(function ($model) use ($loanfields) {
			return array_search($model->id, $loanfields);
		});
		$borrowers = Borrower::where('status', 1)->get();
        return view('admin.loan.loan-create',compact('loanType','fields', 'borrowers', 'loan_type_id'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'borrower' => 'required|exists:borrower,id',
			'loan_type' => 'required|exists:loantype,id'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $loan = new Loan();
        $loan->borrower_id = $request->borrower;
        $loan->loan_type_id = $request->loan_type;
        $loan->save();


        return response()->json([
            'status' => true,
            'msg' => 'Loan created successfully'
			]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = Loan::find($id);
        return view('admin.loan.loan-show',compact('loan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = Loan::find($id);
		$loan_type_id = $loan->loan_type_id;
		$loanType = LoanType::where('id', $loan->loan_type_id)->first();
		$loanfields = json_decode($loanType->loan_fields);
		
		
		$fields = LoanField::whereIn('id', $loanfields)->get();
		$fields = $fields->sortBy(function ($model) use ($loanfields) {
			return array_search($model->id, $loanfields);
		});
		$borrowers = Borrower::where('status', 1)->get();
        return view('admin.loan.loan-edit',compact('loan','loanType','fields', 'borrowers', 'loan_type_id'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:loantype,title,'.$id,
            'loan_fields' => 'required',
            'description' => 'required',
            'icon' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		
        
        $loan = Loan::find($id);
        $loan->title = $request->title;
        $loan->loan_fields = json_encode($request->loan_fields);
        $loan->status = $request->status;
        $loan->description = $request->description;
		if($imageName){
        $loan->icon = $imageName;
		}
        $loan->save();

        

        return response()->json([
            'status' => true,
            'msg' => 'Loan updated successfully'
			]);

    }

	
	
	public function action($id)
    {
        $loan = Loan::with('assign_detail')
		->with('borrower_detail')
		->with('loan_type_detail')->where('id', $id)->first();
		$loan_type_id = $loan->loan_type_id;
		$loanType = LoanType::where('id', $loan->loan_type_id)->first();
		$loanfields = json_decode($loanType->loan_fields);
		
		
		$fields = LoanField::whereIn('id', $loanfields)->get();
		$fields = $fields->sortBy(function ($model) use ($loanfields) {
			return array_search($model->id, $loanfields);
		});
		$borrowers = Borrower::where('status', 1)->get();
		$banks = Bank::where('status', 1)->get();
        return view('admin.loan.loan-action',compact('loan','loanType','fields', 'borrowers', 'loan_type_id', 'banks'));
    }
	
	
	public function getStatusForm($loan_bank_id){
		$loan = LoanBankStatus::where('loan_bank_id', $loan_bank_id)->latest()->first();
		
		$parent_status = LoanStatus::where('parent_id', 0)->get();
		$sub_status = "";
		if(isset($loan->loan_status)){
		$sub_status = LoanStatus::where('parent_id', $loan->loan_status)->get();
		}else{
			$sub_status = array();
		}
		return view('admin.loan.model.status-form',compact('parent_status', 'sub_status', 'loan_bank_id', 'loan'));
		
	}
	
	public function updateLoanStatus(Request $request){
		
		$validator = Validator::make($request->all(), [
            'loan_bank_id' => 'required|exists:loan_bank,id',
            'loan_status' => 'required',
            'loan_sub_status' => 'required',
            'internal_comment' => '',
            'external_comment' => '',
            'ps_loan_date' => 'required',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$bank_loan = LoanBankStatus::where('loan_bank_id', $request->loan_bank_id)->where('loan_sub_status', $request->loan_sub_status)->first();
		
		if(isset($bank_loan->loan_bank_id)){
			
			return response()->json([
			'status' => false,
			'errors' => array('loan_sub_status' => ["Status Already added"])
			]);
			
		}
		
		$loan = new LoanBankStatus();
		$loan->loan_bank_id = $request->loan_bank_id;
		$loan->loan_status = $request->loan_status;
		$loan->loan_sub_status = $request->loan_sub_status;
		$loan->internal_comment = $request->internal_comment;
		$loan->external_comment = $request->external_comment;
		$loan->ps_loan_date = $request->ps_loan_date;
		$loan->updated_by = Auth()->user()->id;
		$loan->save(); 
		
		
		
		
		return response()->json([
            'status' => true,
            'msg' => 'Status Updated'
			]);
			
			
		
		
	}
	
	public function getSubStatus($parent_id){
		
		$sub_status = LoanStatus::where('parent_id', $parent_id)->get();
		return response()->json([
            'status' => true,
            'data' => $sub_status
			]);
	}
	
	public function getAssignForm($loan_id){
		$loan = Loan::find($loan_id);
		$users = User::role('Emitra')->get();
		return view('admin.loan.model.assign-form',compact('loan', 'users'));
		
	}
	
	public function updateLoanAssign(Request $request){
		
		$validator = Validator::make($request->all(), [
            'lona_id' => 'required|exists:loan,id',
            'assign_to' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$loan = Loan::find($request->lona_id);
		$loan->assign_to = $request->assign_to;
		$loan->save(); 
		return response()->json([
            'status' => true,
            'msg' => 'Assign TO Updated'
			]);
		
	}
	

	
	public function addBank(Request $request, $loan_id){
		$validator = Validator::make($request->all(), [
            'bank' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$bank_loan = LoanBank::where('bank_id', $request->bank)->where('loan_id', $loan_id)->first();
		
		if(isset($bank_loan->bank_id)){
			
			return response()->json([
			'status' => false,
			'errors' => array('bank' => ["Bank already added"])
			]);
			
		}
        
        $bank = new LoanBank();
        $bank->bank_id = $request->bank;
        $bank->loan_id = $loan_id;
        $bank->save();
		
		
		return response()->json([
			'status' => true,
			'msg' => 'Bank added'
			]);
		
	}
	
	public function bankList($loan_id){
		
		$data = LoanBank::with('bank_detail')->where('loan_id', $loan_id)
		->with(['loan_bank_status_detail' => function($query){
			$query->with('loan_status_detail');
			$query->with('loan_sub_status_detail');
			$query->latest();
			
		}])
		->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) use($loan_id){
                        $btn =' ';
                        						
						if(Auth()->user()->can('Loan Status Add')){
                        $btn .= ' <button type="button" data-url="'.route('loan-status-form', $row->id).'" class="edit btn btn-primary btn-sm statusDetail">Update Status</button>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        
		
		
	}
	
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Loan::find($id)->delete();
    }


    
}