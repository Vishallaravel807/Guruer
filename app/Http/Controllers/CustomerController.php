<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Language;
use App\Models\UserLanguage;
use Illuminate\Support\Facades\Auth;
use Session;
use DB;

class CustomerController extends Controller
{
    
    public function customerDashboard()
    {
        //This function is for customer dashboard
        if (Auth::guard('user')->check()) {
			// Redirect to the user dashboard if authenticated
			return view('front.user.customer_dash');
		}
		else{
			return redirect()->to('/login');
		}
    }

    public function updateProfile(Request $request)
    {
        //This function is for update the customer profile
        $customer = User::where('id', auth('user')->id())->first();
        $imageName=$customer->profile_image;
        if ($request->isMethod('post')) {

            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = "cus".time().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('/admin/uploads/user'), $imageName);
            }

           DB::table('users')
                  ->where('id', auth('user')->id())
                  ->update([
                  'first_name' => trim($request->first_name),
                  'last_name' => trim($request->last_name),
                  'profile_image' => $imageName,
                  'gender' => $request->gender,
                  'address' => $request->address,
                  'country_id'=>$request->country_id,
                  'city_id' => $request->city_id,
                  'state_id' => $request->state_id,
                  'zipcode' => $request->zipcode,
              ]);

              UserLanguage::where('user_id', auth('user')->id())->delete();

              $languages = $request->language;

              foreach($languages as $key=> $value){
                $userLanguage = new UserLanguage();
                $userLanguage->user_id      = auth('user')->id();
                $userLanguage->language_id	= $value;
                $userLanguage->save();
              }



              Session::flash('message', 'Your Profile Updated Sucessfully!');
              return redirect()->to('/customerProfile');
        }
        

        $countries = DB::table('master_country')->select('country_id','country_name')->where('country_status',1)->get();
        $state = DB::table('master_state')->select('state_id','state_name')->get();
        $city = DB::table('master_city')->select('city_id','city_name')->get();
        $language = Language::all();
        $UserLanguage = UserLanguage::where('user_id', auth('user')->id())->get();
        
        return view('front.user.customer_profile',compact('customer','countries','state','city','language','UserLanguage'));
    }
}