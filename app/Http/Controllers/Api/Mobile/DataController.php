<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Borrower;
use App\LoanType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
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
	
	
	
	
}
