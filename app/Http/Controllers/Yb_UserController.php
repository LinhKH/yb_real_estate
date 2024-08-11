<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Users;
use App\Models\Property;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;
use PDO;
use DB;

class Yb_UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
                $data = Users::leftJoin('countries','countries.country_id','=','users.user_country')
                ->leftJoin('states','states.state_id','=','users.user_state')
                ->leftJoin('cities','cities.city_id','=','users.user_city')
                ->orderBy('user_id','desc')->get();
                return Datatables::of($data)
                ->addColumn('user_image',function($row){
                    if($row->user_image != ''){
                        $img = '<img src="'.asset("public/users/".$row->user_image).'" width="70px">';
                    }else{
                        $img = '<img src="'.asset("public/users/default.png").'" width="70px">';
                    }
                    return $img;
                })
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status = '<span class="btn btn-xs btn-success">Active</span>';
                    }else{
                        $status = '<span class="btn btn-xs btn-danger">Blocked</span>';
                    }
                    return $status;
                })
                ->addColumn('location', function($row){
                    $location = $row->city_name.', '.$row->state_name.', '.$row->country_name;
                    return $location;
                })
                ->addColumn('action', function($row){
                    $checked = ($row->status == '0')? 'checked' : ''; 
                    $btn = '<div class="checkbox">
                    <input type="checkbox" class="status-user" data-id="'.$row->user_id.'" data-status="'.$row->status.'" id="checkbox'.$row->user_id.'" '.$checked.'>
                    <label for="checkbox'.$row->user_id.'"></label>
                </div>';
                    return $btn;
                })
                // <a href="users/'.$row->user_id.'/edit" class="btn btn-success btn-sm">Edit</a>
                // <a href="javascript:void(0)" class="delete-user btn btn-danger btn-sm" data-id="'.$row->user_id.'">Delete</a>
                ->rawColumns(['user_image','location','status','action'])
                ->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       // return $request->input();
        $request->validate([ 
            'username'=>'required',
            'phone'=>'required',
            'email'=>'required|email|unique:users,user_email',
            // 'img'=>'image|mimes:jpeg,png,jpg|max:2048',
            'password'=>'required',
        ]);

        if($request->img){
            $image = $request->user_name.rand().$request->img->getClientOriginalName();
            $request->img->move(public_path('users'),$image);
        }else {
            $image= "";
        }

        $users = new Users();
        $users->username = $request->input("username");
        $users->user_phone = $request->input("phone");
        $users->description = htmlspecialchars($request->input("description"));
        $users->user_email  = $request->input("email");
        $users->user_password  = Hash::make($request->input("password"));
        $users->user_image = $image;
        $result =  $users->save();
        return $result;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $users = Users::where(['user_id'=>$id])->first();
        return view('admin.users.edit',['users'=>$users]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = session()->get('user_id');
           $request->validate([
            'img'=>'image|mimes:jpeg,png,jpg|max:2048',
            'username'=>'required',
            'phone'=>'required',
        ]);

        if($request->img != ''){        
            $path = public_path().'/users/';
            //code for remove old file
            if($request->old_img != ''  && $request->old_img != null){
                $file_old = $path.$request->old_img;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->img;
            $image = $request->user_name.rand().$request->img->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $request->old_img;
        }

        $country = $state = $city = '';
        if($request->country != ''){
            $country = $request->country;
        }
        if($request->state != ''){
            $state = $request->state;
        }
        if($request->city != ''){
            $city = $request->city;
        }

        $users = Users::where(['user_id'=>$id])->update([
            "user_image"=>$image,
            "username"=>$request->input('username'),
            "user_phone"=>$request->input('phone'),
            "description" => htmlspecialchars($request->input("description")),
            "user_country" => $country,
            "user_state" => $state,
            "user_city" => $city,
        ]);
        return $users;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $destroy = Users::where('user_id',$id)->delete();
        return  $destroy;
    }

    public function yb_login(Request $req){
        //return $req->session()->get('user');
        if($req->input()){
            $req->validate([
                'user_name' => 'required|email',
                'user_password' => 'required',
            ]);

            $user = $req->input('user_name');
            $pass = $req->input('user_password');

            $login = Users::select(['user_id','username','user_email','user_password','status'])
                            ->where('user_email',$user)
                            ->first();
            if($login){
                if($login['status'] == '1'){
                    if(Hash::check($pass,$login['user_password'])){
                        $req->session()->put('user_id',$login['user_id']);
                        $req->session()->put('username',$login['username']);
                        return '1'; 
                    }else{
                        return 'Email Address and Password Not Matched.'; 
                    }
                }else{
                    return 'Your Account is Blocked'; 
                }
            }else{
                return 'Email Does Not Exists'; 
            }
        }else{
            return view('public.login');
        }
    }


    public function yb_signup(Request $request){
        if($request->input()){
            $request->validate([ 
                'username'=>'required',
                'phone'=>'required',
                'email'=>'required|email|unique:users,user_email',
                'password'=>'required',
                'country'=>'required',
                'state'=>'required',
                'city'=>'required',
            ]);
    
            $users = new Users();
            $users->username = $request->input("username");
            $users->user_phone = $request->input("phone");
            $users->user_email  = $request->input("email");
            $users->user_password  = Hash::make($request->input("password"));
            $users->user_country  = $request->input("country");
            $users->user_state  = $request->input("state");
            $users->user_city  = $request->input("city");
            $result =  $users->save();
            return $result;
        }else{
            $country = Country::get();

            return view('public.signup',['country'=>$country]);
        }
    }


    public function yb_logout(Request $request){
        $request->session()->forget('user_id');
        $request->session()->forget('username');
        return redirect('/');
    }

    public function yb_profile(){
        if(session()->has('user_id')){
            $user = session()->get('user_id');
            $users = Users::WHERE(['user_id'=> $user])->first();
            $country = Country::all();
            $state = State::where('country_id',$users->user_country)->get();
            $city = City::where('state_id',$users->user_state)->get();
            return view('public.profile',['user'=> $users,'country'=>$country,'state'=>$state,'city'=>$city]);
        }else{
            return redirect('/login');
        }
    }

    public function yb_my_listing(){
        if(session()->has('user_id')){
            $user = session()->get('user_id');
            $ads = Property::select(['property.*','cities.city_name as city','category.category_name as cat_name','purpose.name as purpose_name','payment_details.end_date'])
                   ->LeftJoin('cities','property.city','=','cities.city_id')
                   ->LeftJoin('category','property.category','=','category.id')
                   ->LeftJoin('purpose','property.purpose','=','purpose.id')
                   ->LeftJoin('payment_details','property.ads_id','=','payment_details.post')
                   ->where(['property.user_id'=>$user])->get();
            return view('public.my_property',['ads'=> $ads]);
        }else{
            return redirect('/login');
        }
    }


    public function yb_user_listing($user){
        $user_detail = Users::select(['users.*','countries.country_name'])->where('username',$user)
                    ->leftJoin('countries','countries.country_id','=','users.user_country')
                    ->first();
        // return $user_id;
        $ads = Property::select(['property.*','cities.city_name as city','category.category_name as cat_name','purpose.name as purpose_name','users.username','users.user_image'])
                   ->LeftJoin('cities','property.city','=','cities.city_id')
                   ->LeftJoin('category','property.category','=','category.id')
                   ->LeftJoin('purpose','property.purpose','=','purpose.id')
                   ->LeftJoin('users','property.user_id','=','users.user_id')
                   ->where(['property.user_id'=>$user_detail->user_id])->paginate(10);
                //    return $user_detail;
        return view('public.user_property',['ads'=> $ads,'userInfo'=> $user_detail]);
    }



    public function yb_changeStatus(Request $request){
        $id = $request->id;
        $status = $request->status;
        if($status == '1'){
            $status = '0';
        }else{
            $status = '1';
        }
        $response = Users::where('user_id','=',$id)->update([
            'status'=>$status
        ]);
        return $response;
    }


    public function yb_Insertfavourite(Request $request){
        $id = $request->id;
        if(session()->has('user_id')){
            $user = session()->get('user_id');
            $favourites = Users::where('user_id',$user)
                            ->pluck('favourites');
            $fav_array = [];
            if(empty($favourites)){
                array_push($fav_array,$id);
            }else{
                $fav_array = explode(',',$favourites[0]);
                if (($key = array_search($id, $fav_array)) !== false) {
                    unset($fav_array[$key]);
                }else{
                    array_push($fav_array,$id);
                }
            }
            $update = Users::where('user_id',$user)->update([
                'favourites' => implode(',',array_filter($fav_array))
            ]);
            return $update;
        }else{
            return 'false';
        }
    }

    public function yb_myfavourite(){
        if(session()->has('user_id')){
            $user = session()->get('user_id');
            $favourites = Users::where('user_id',$user)->pluck('favourites');
            if(empty($favourites)){
                $ads = [];
            }else{
                $favourites = array_filter(explode(',',$favourites[0]));
                $ads = Property::select(['property.*','countries.country_name as country','states.state_name as state','cities.city_name as city','purpose.name as purpose_name'])
                            ->leftJoin('countries','property.country','=','countries.country_id') 
                            ->leftJoin('states','property.states','=','states.state_id') 
                            ->leftJoin('cities','property.city','=','cities.city_id') 
                            ->leftJoin('purpose','property.purpose','=','purpose.id') 
                            ->whereIn('property.ads_id',$favourites)->paginate(10);
                            // return $ads;
            }
            
            return view('public.my_favourite',['ads'=> $ads]);
        }else{
            return redirect('/login');
        }
        
    }
}
