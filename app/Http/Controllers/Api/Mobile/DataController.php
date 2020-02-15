<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Borrower;
use App\LoanField;
use App\LoanType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use DB;
class DataController extends Controller
{
    
	
	
	public function loanList(Request $request)
    {
		$loans = LoanType::where('status', 1)->get();
        return response()->json([
            'status' => true,
            'data' => $loans
        ]);
    }
	
	public function loanFields(Request $request)
    {
		$loanType = $request->loan_type;
		
		$loan_fields = LoanType::where('id', $loanType)->first()->loan_fields;
		
		$loan_fields = json_decode($loan_fields);
		$loan_fields1 = implode(',',$loan_fields);
		
		$fields = LoanField::whereIn('id', $loan_fields)->orderByRaw(DB::raw("FIELD(id, '$loan_fields1') DESC"))->get();
		
        return response()->json([
            'status' => true,
            'data' => $fields
        ]);
    }
	
	
	
	
}
