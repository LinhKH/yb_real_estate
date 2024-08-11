<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\State;
use App\Models\Property;
use App\Models\Users;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;

class Yb_CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $state = State::all();
        if ($request->ajax()) {
            //$data = City::orderBy('city_id','desc')->get();
            $data = City::select(['cities.*','states.state_name as state'])
                ->LeftJoin('states','cities.state_id','=','states.state_id')
                ->orderBy('cities.city_id','desc')->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->city_id.'" class="edit_city btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-city btn btn-danger btn-sm" data-id="'.$row->city_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.city.index',['state'=>$state]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $request->validate([
            'city'=> 'required|unique:cities,city_name',
            'state' => 'required'
        ]);

        $city = new City();
        $city->city_name = $request->input("city");
        $city->state_id = $request->input("state");
        $result =  $city->save();


        $data = City::select(['cities.*','states.state_name as state'])
        ->leftJoin('states','cities.state_id','=','states.state_id')
        ->orderBy('cities.city_id','desc')->get()->toArray();
        Storage::disk('local')->put('location.json', json_encode($data));
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
        $city = City::where('city_id',$id)->get();
        return $city;
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
        //
        $request->validate([
            'city'=>'required|unique:cities,city_name,'.$id.',city_id',
            'state' => 'required'
        ]);

        $city = City::where(['city_id'=>$id])->update([
            "city_name"=>$request->input('city'),
            "state_id"=>$request->input('state'),
        ]);
        $data = City::select(['cities.*','states.state_name as state'])
        ->leftJoin('states','cities.state_id','=','states.state_id')
        ->orderBy('cities.city_id','desc')->get()->toArray();
        Storage::disk('local')->put('location.json', json_encode($data));
        return '1';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check1 = Property::where('states','=',$id)->count();
        $check2 = Users::where('user_state','=',$id)->count();
        if($check1 == 0 || $check2 == 0){
            $destroy = City::where('city_id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't Delete this (This Country May be used in Properties OR Users List.)";
        }
        
    }
}
