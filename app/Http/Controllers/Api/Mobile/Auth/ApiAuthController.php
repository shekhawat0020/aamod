<?php

namespace App\Http\Controllers\Api\Mobile\Auth;

use App\Borrower;
use App\ForgotOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
class ApiAuthController extends Controller
{
    
	
	//send Login otp
	public function sendLoginOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10',
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		//send otp
		$otp = rand(1000,9999); 
		$signature = $request->signature;
        $this->sendSMS("<#> Your OTP is: ".$otp." ".$signature, $request->mobile);
		
		// forgot otp table also use for verify mobile
		$saveotp = new ForgotOtp;
		$saveotp->mobile = $request->mobile;
		$saveotp->otp = $otp;
		$saveotp->save();
		
		return response()->json([
			'status' => true,
			'msg' => 'Otp Send success'
			]);
		
    }
	
	
	public function registorForLogin(Request $request){
		
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10|exists:borrower,mobile_no',
            'name' => 'required',
            'email' => 'nullable|email|unique:borrower,email'
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		//update Borrower
		$user = Borrower::where('mobile_no', $request->mobile)
		->update(['name' => $request->name, 'email' => $request->email]); 

		$user = Borrower::where("mobile_no",$request->mobile)->first();
			$tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(12);
				$token->save();
				return response()->json([
					'status' => true,
					'type' => 'login',					
					'user' => $user,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse(
						$tokenResult->token->expires_at
					)->toDateTimeString()
				]);
		
		
	}
	
	public function verifyLoginOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10|exists:forgot_otp,mobile',
            'otp' => 'required'
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){
			
			return response()->json([
			'status' => false,
			'message' => 'Wrong Otp'
			]);
			
		}else{
			ForgotOtp::where('mobile', $request->mobile)->delete();
		}
		
		//if user not registor
		$exist = Borrower::where('mobile_no', $request->mobile)->first();
		if(!isset($exist->name)){
			$borrower = new Borrower();
			$borrower->mobile_no = $request->mobile;
			$borrower->save();
			
			return response()->json([
			'status' => true,
			'type' => 'registor',
			'message' => 'Otp Verify'
			]);
		}else{
			$user = Borrower::where("mobile_no",$request->mobile)->first();
			$tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(12);
				$token->save();
				return response()->json([
					'status' => true,
					'type' => 'login',					
					'user' => $user,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse(
						$tokenResult->token->expires_at
					)->toDateTimeString()
				]);
			
		}
		
		  
		
    }
	
	public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
	
	
	//send forgot password otp
	public function sendOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10',
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		//send otp
		$otp = rand(1000,9999); 
        $this->sendSMS("Your OTP ".$otp." Please use for change password", $request->mobile);
		$saveotp = new ForgotOtp;
		$saveotp->mobile = $request->mobile;
		$saveotp->otp = $otp;
		$saveotp->save();
		
		
		
		
		return response()->json([
			'status' => true,
			'msg' => 'Otp Send success'
			]);
		
    }
	
	
	public function passwordSet(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10|exists:api_users',
            'otp' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){
			
			return response()->json([
			'status' => false,
			'errors' => ['otp'=> ['Wrong Otp.']]
			]);
			
		}else{
			ForgotOtp::where('mobile', $request->mobile)->delete();
		}
		
		//change password
		$user = ApiUser::where('mobile', $request->mobile)->update(['password' => Hash::make($request->password)]);              
		
		return response()->json([
			'status' => true,
			'message' => 'Password Updated.'
			]);
		
    }
	
	
	public function sendSMS($message, $mobile){
        
        $endpoint = "http://prosms.easy2approach.com/api/sendhttp.php";
        $client = new \GuzzleHttp\Client();        
        $params['query'] = array(
		'authkey' => '4669Atyt2mgj1RV35943a18f', 
		'mobiles' => $mobile,
		'message' => $message,
		'sender' => 'UDRBZR',
		'route' => '4',
		'country' => '91'		
		);        
		
        $response = $client->get( $endpoint, $params);
        $content = $response->getBody()->getContents();
        return $content;        
    }
	
	
	
}
