<?php

namespace App\Http\Controllers\Api\Mobile\Auth;

use App\ApiUser;
use App\ApiUserProfiles;
use App\ForgotOtp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            
        ]);
		
		$validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mobile' => 'required|numeric|digits:10|unique:api_users',
            'password' => 'required|confirmed|min:6',
			'otp'  => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		//verify otp
		
		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){
			
			return response()->json([
			'status' => false,
			'errors' => ['otp'=> ['Wrong Otp.']]
			]);
			
		}else{
			ForgotOtp::where('mobile', $request->mobile)->delete();
		}
		
		//end verify otp
		
		
		
        $user = new ApiUser;
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($request->password);
        $user->save();       
		
		return response()->json([
			'status' => true,
			'message' => 'Successfully created user!'
			]);
    }
	
	
	public function login(Request $request) {
        
		
		$validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
        $credentials = request(['mobile', 'password']);
        $user = ApiUser::where("mobile",$request->mobile)->first();
       if($user){
		   
		   $profile = ApiUserProfiles::where('user_id', $user->id)->count();
		   
           if (Hash::check($request->password,$user->password)) {
			   $tokenResult = $user->createToken('Personal Access Token');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addWeeks(12);
				$token->save();
				return response()->json([
					'status' => true,
					'user' => $user,
					'profiles' => $profile,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse(
						$tokenResult->token->expires_at
					)->toDateTimeString()
				]);
		   }else{
            return response()->json([
			'status' => false,
			'errors' => ['error' => 'Wrong Password']
			]);
			
		   }
	   }else{
		   return response()->json([
			'status' => false,
			'errors' => ['error' => 'Mobile no not exist']
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
            'mobile' => 'required|numeric|digits:10|exists:api_users',
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
	
	//send forgot password otp
	public function sendVerifyOtp(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
		
		//send otp
		$otp = rand(1000,9999); 
        $this->sendSMS("Your OTP ".$otp." Please use for Registration", $request->mobile);
		
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
