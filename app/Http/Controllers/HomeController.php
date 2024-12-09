<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserLanguage;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Product;
use App\Models\FebricType;
use App\Models\ProductImage;
use App\Models\DocumentProd;
use App\Models\UserVerify;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use DB;
use Hash;
use Mail; 

class HomeController extends Controller{

	public function index(){
		
		$latitude = session('latitude');
    	$longitude = session('longitude');
		
		return view("front/index",compact('latitude', 'longitude'));
	}
	public function storeLocation(Request $request)
	{
		// Save the location to the session
		session(['latitude' => $request->latitude, 'longitude' => $request->longitude]);

		return response()->json(['success' => true]);
	}
	public function login()
	{
		//This function is for login 
		if (Auth::guard('user')->check()) {
			// Redirect to the user dashboard if authenticated
			return redirect()->to('/customerDashboard');
		}
		return view("login");
	}
	public function loginchk(Request $request)
	{
		//This function is for login the customer
		$request->validate([
			"email" => "required|email",
			"password" => "required"
		]);
		
		if (Auth::guard("user")->attempt([
			"email_id" => $request->email,
			"password" => $request->password
		])) 
		{
			$user = Auth::guard("user")->user();

			if (!$user->is_email_verified) {
				Auth::guard("user")->logout();
				return redirect()->back()->with('error', 'Please verify your email before logging in.');
			}
			return redirect()->to('/customerDashboard');
		}
		else {
			// Flash a message and redirect back on failure
			return back()->with('error','Email  id & Password is incorrect');
		}
	}
	public function register()
	{
		//This is for new registeration
		if (Auth::guard('user')->check()) {
			// Redirect to the user dashboard if authenticated
			return redirect()->to('/customerDashboard');
		}
		return view("register");
	}
	public function signup(Request $request)
	{
		//This function is for signup the user
		$request->validate([
			"email_id" => "required|email",
			"password" => "required"
		]);
		$user = User::where('email_id', $request->email_id)->first();
		if($user)
		{
			return back()->with('error','Email  id already exist as customer , please login');
		}
		else
		{
			$user = new User;
			$user->first_name = trim($request->first_name);
			$user->email_id = $request->email_id;
			$user->mobile_number = $request->number_field;
			$user->password = Hash::make($request->password);
			$user->user_status = "1";
			$user->customer_type = "0";
			$user->is_social= "0";
			$user->is_deleted= "0";
			$user->save();
			$user_id = $user->id;

			$token = Str::random(64);

			UserVerify::create([
				'user_id' => $user_id, 
				'token' => $token
			  ]);

			Mail::send('emailVerificationEmail', ['token' => $token], function($message) use($request){

				$message->to($request->email_id);
				$message->subject('Email Verification Mail');
  
			});

			Session::flash('message', 'User Register Sucessfully!');

			return redirect()->to('/login');
		}
	}


	public function verifyAccount($token)

    {

        $verifyUser = UserVerify::where('token', $token)->first();
		$user = User::where('id',$verifyUser->user_id)->first();
        $message = 'Sorry your email cannot be identified.';

  

        if(!is_null($verifyUser) ){

            if(!$user->is_email_verified == '1') {

                $user->is_email_verified = '1';

                $user->save();

                $message = "Your e-mail is verified. You can now login.";

            } else {

                $message = "Your e-mail is already verified. You can now login.";

            }

        }

  

      return redirect('login')->with('message', $message);

    }

	public function logout(Request $request)
    {
        // Log out the authenticated user
        Auth::guard('web')->logout();
		Auth::guard('user')->logout();
		Auth::guard('vendor')->logout();

        // Clear all session data
        Session::flush();
        // Redirect to login or home page
        return redirect('/login')->with('status', 'You have been logged out successfully.');
    }
	public function searchTailor(Request $request)
	{
		//This function is for search the tailor list
		$data['tailors'] = Vendor::where('vendor_type','1')->get();
		return view("front/tailorlist",$data);
	}
	public function tailorDetails($id){
        $data['tailor'] = Vendor::where('vendor_id',$id)->first();
		return view("front/tailordetails",$data);
	}
	public function searchHome(Request $request)
	{
		//This function is for home page search
		$latitude = session('latitude');
    	$longitude = session('longitude');

		$keyword = $request->search;

		$results = DB::select(" SELECT id, name, 'tailor_speciality' AS type 
						FROM tailor_speciality WHERE name LIKE ?
						UNION ALL
						SELECT id, name, 'fabric_type' AS type FROM fabric_type WHERE name LIKE ?", ["%$keyword%", "%$keyword%"]);

		return $results;
	}
	

	/*********************Master Pages**************************/
	public function dt()
	{
		$data['allUsers'] = User::where('is_deleted','0')->get();
		return view("front/browse_febric",$data);
	}
	public function guruerDetail($id)
	{
		$data['guruer']	= User::where('id',$id)->first();
		$data['userLanguages'] = DB::table('user_languages')
								->join('users', 'users.id', '=', 'user_languages.user_id')
								->join('master_language', 'master_language.language_id', '=', 'user_languages.language_id')
								->select('master_language.language_name','user_languages.user_id')
								->get();
		$data['allUsers'] = User::where('user_type','2')->where('is_deleted','0')->get();
		return view("front/guruer_detail",$data);
	}	
	public function AllGuruer()
	{
		$data['allUsers'] = User::where('user_type','2')->where('is_deleted','0')->get();
		$data['userLanguages'] = DB::table('user_languages')
								->join('users', 'users.id', '=', 'user_languages.user_id')
								->join('master_language', 'master_language.language_id', '=', 'user_languages.language_id')
								->select('master_language.language_name','user_languages.user_id')
								->get();
		return view("front/all_guruer",$data);
	}
	public function productList(Request $request)
	{
		return view("front/product_list");
	}
	public function vendorDash()
	{
		return view("front/vendor_dash");
	}
	
}