<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Country;
use App\Models\UserContact;
use Yajra\DataTables\DataTables;


class SettingController extends Controller
{
    //

    public function yb_banner_settings(Request $request){
        
        if($request->input()){
            //return $request;
            $request->validate([
                'image'=> 'image|mimes:jpg,jpeg,png,svg',
                'title'=> 'required',
                'sub_title'=> 'required',
            ]);

            if($request->image != ''){        
                $path = public_path().'/company/';

                //code for remove old file
                if($request->old_image != ''  && $request->old_image != null){
                    $file_old = $path.$request->old_image;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->image;
                $filename = rand().$file->getClientOriginalName();
                $file->move($path, $filename);
            }else{
                $filename = $request->old_image;
            }

            $update = DB::table('banner_settings')->update([
                'image'=>$filename,
                'title'=>$request->title,
                'sub_title'=>$request->sub_title,
             
            ]);
            return $update;

        }else{
            $settings = DB::table('banner_settings')->get();
            return view('admin.settings.banner',['data'=>$settings]);
        }
    }


    public function yb_general_settings(Request $request){
        
        if($request->input()){
            //return $request;
            $request->validate([
                'logo'=> 'image|mimes:jpg,jpeg,png,svg',
                'com_name'=> 'required',
                'com_email'=> 'required',
                'address'=> 'required',
                'phone'=> 'required',
                'currency'=> 'required',
                'f_address'=> 'required',
            ]);

            if($request->logo != ''){        
                $path = public_path().'/company/';

                //code for remove old file
                if($request->old_logo != ''  && $request->old_logo != null){
                    $file_old = $path.$request->old_logo;
                    if(file_exists($file_old)){
                        unlink($file_old);
                    }
                }

                //upload new file
                $file = $request->logo;
                $filename = rand().$file->getClientOriginalName();
                $file->move($path, $filename);
            }else{
                $filename = $request->old_logo;
            }

            $latitude = $longitude = '';
            if($request->latitude != ''){
                $latitude = $request->latitude;
            }
            if($request->longitude != ''){
                $longitude = $request->longitude;
            }

            $update = DB::table('general_settings')->update([
                'com_logo'=>$filename,
                'com_name'=>$request->com_name,
                'com_email'=>$request->com_email,
                'com_phone'=>$request->phone,
                'address'=>$request->address,
                'description'=>$request->description,
                'copyright_text'=>$request->f_address,
                'cur_format'=>$request->currency,
                'latitude'=>$latitude,
                'longitude'=>$longitude,
             
            ]);
            return $update;

        }else{
            $settings = DB::table('general_settings')->get();
            return view('admin.settings.general',['data'=>$settings]);
        }
        //return view('admin.settings.general');
    }

    public function yb_profile_settings(Request $request){

        $country = Country::all();
        if($request->input()){
            $request->validate([
                'admin_name'=> 'required',
                'admin_email'=> 'required|email:rfc',
                'username'=> 'required',
            ]);

            $update = DB::table('admin')->update([
                'admin_name'=>$request->admin_name,
                'admin_email'=>$request->admin_email,
                'user_name'=>$request->username,
            ]);
            return $update;

        }else{
            $settings = DB::table('admin')->get();
            return view('admin.settings.profile',['data'=>$settings,'country'=>$country]);
        }
    }

    public function yb_change_password(Request $request){
        // return $request->input();

        if($request->input()){
            $request->validate([
                'password'=> 'required',
                'new_pass'=> 'required',
                'con_pass'=> 'required'
            ]);

            $select = DB::table('admin')->pluck('user_password');

            if(Hash::check($request->password,$select[0])){
                $update = DB::table('admin')->update([
                    'user_password'=>Hash::make($request->new_pass)
                ]);
                return '1';
            }else{
                return response()->json(['false'=>'Please Enter Correct Old Password']);
            }
        }
    }

    public function yb_social_settings(Request $request){
        if($request->input()){
            $facebook = '';
            if($request->facebook != ''){
                $facebook = $request->facebook;
            }
            $twitter = '';
            if($request->twitter != ''){
                $twitter = $request->twitter;
            }
            $linked_in = '';
            if($request->linked_in != ''){
                $linked_in = $request->linked_in;
            }
            $you_tube = '';
            if($request->you_tube != ''){
                $you_tube = $request->you_tube;
            }
            $google_plus = '';
            if($request->google_plus != ''){
                $google_plus = $request->google_plus;
            }

            $update = DB::table('social-setting')->update([
                'facebook'=>$facebook,
                'twitter'=>$twitter,
                'linked_in'=>$linked_in,
                'you_tube'=>$you_tube,
                'google_plus'=>$google_plus,
            ]);
            return $update;

        }else{
            $settings = DB::table('social-setting')->get();
            return view('admin.settings.social',['data'=>$settings]);
        }
    }

    public function yb_contact(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = UserContact::orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
            $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="viewContact btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        } 
        return view('admin.settings.contact'); 
    }

    public function yb_Contactview($id){
        //
        $usercontact = UserContact::where(['id'=> $id])->get();
        $output = '';
            foreach($usercontact as $value){
            $output .= '<tr>
                            <th>UserName :</th>
                            <td scope="row" class="user">'.$value["user_name"].'</td>
                        </tr>
                        <tr>
                            <th>Email :</th>
                            <td>'.$value["email"].'</td>
                        </tr>
                        <tr>
                            <th>Phone :</th>
                            <td>'.$value["phone"].'</td>
                        </tr>
                        <tr>
                            <th>Description :</th>
                            <td>'.$value["description"].'</td>
                        </tr>';
            } 
        return $output;      
    }
}
