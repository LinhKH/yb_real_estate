<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Property;
use App\Models\Users;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $country = Country::all();
        if ($request->ajax()) {
            //$data = State::orderBy('state_id','desc')->get();
            $data = State::select(['states.*','countries.country_name as country'])
                ->LeftJoin('countries','states.country_id','=','countries.country_id')
                ->orderBy('states.state_id','desc')->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" data-id="'.$row->state_id.'" class="edit_state btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-state btn btn-danger btn-sm" data-id="'.$row->state_id.'">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.states.index',['country'=>$country]);
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
            'state'=> 'required|unique:states,state_name,NULL,state_id,country_id,'.$request->country,
            'country' => 'required'
        ]);

        $state = new State();
        $state->state_name = $request->input("state");
        $state->country_id = $request->input("country");
        $result =  $state->save();
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
        $state = State::where('state_id',$id)->get();
        return $state;
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
            'state'=> 'required|unique:states,state_name,'.$id. ',state_id',
            'country' => 'required'
        ]);

        $state = State::where(['state_id'=>$id])->update([
            "state_name"=>$request->input('state'),
            "country_id"=>$request->input('country'),
        ]);
        return $state;
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
        $check3 = City::where('state_id','=',$id)->count();
        if($check1 == 0 || $check2 == 0 || $check3 == 0){
            $destroy = State::where('state_id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't Delete this (This Country May be used in Properties OR Users OR Cities List.)";
        }
    }
}
