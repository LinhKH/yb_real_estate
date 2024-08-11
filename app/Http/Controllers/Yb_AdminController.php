<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Users;
use App\Models\Facility;
use App\Models\Property;
use App\Models\Category;
use App\Models\GeneralSetting;


use Illuminate\Http\Request;

class Yb_AdminController extends Controller
{
	//
	public function yb_index(Request $request){

		if($request->input()){

			$request->validate([
				'username'=>'required',
				'password'=>'required',
			]); 
			// return Hash::make($request->input('password'));
			$login = Admin::where(['user_name'=>$request->username])->pluck('user_password')->first();

			if(empty($login)){
				return response()->json(['username'=>'Username Does not Exists']);
			}else{
				if(Hash::check($request->password,$login)){
					$admin = Admin::first();
					$request->session()->put('admin','1');
					$request->session()->put('admin_name',$admin->admin_name);
					return '1';
					// return response()->json(['success'=>'1']);
				}else{
					return response()->json(['password'=>'Username and Password does not matched']);
				}
			}
			
		}else{
		   	return view('admin.admin');
		}
		
	}

    public function yb_dashboard(){

		$adsCount = Property::count(); 
		$category = Category::count(); 
		$facility = Facility::count(); 
		$users = Users::count();

        return view('admin.dashboard',['ads'=> $adsCount,'category'=>$category,'facility'=> $facility,'user'=> $users]);
	}
	
	public function yb_logout(Request $req){
		Auth::logout();
		session()->forget('admin');
		session()->forget('admin_name');
		return '1';
	}
}
