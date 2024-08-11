<?php

namespace App\Http\Controllers;
use App\Models\Facility;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_FacilityController extends Controller
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
            $data = Facility::orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('type', function($row){
                if($row->type == '1'){
                    $type = '<span class="btn btn-xs btn-info">Indoor</span>';
                }else{
                    $type = '<span class="btn btn-xs btn-primary">Outdoor</span>';
                }
                return $type;
            })
            ->addColumn('action', function($row){
            $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="edit_facility btn btn-success btn-sm">Edit</a>  <button type="button" value="delete" class="btn btn-danger btn-sm delete-facility" data-id="'.$row->id.'">Delete</button>';
                return $btn;
            })
            ->rawColumns(['type','action'])
                ->make(true);
        } 
        return view('admin.facility.index'); 
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
        // return $request->input();
        $request->validate([
            'facility'=>'required|unique:facilities,name',
            'type'=>'required',
        ]);

        $facility = new Facility();
        $facility->name = $request->input("facility");
        $facility->type = $request->input("type");
        $result = $facility->save();
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
        $amenity = Facility::where(['id'=>$id])->get();
        return $amenity;
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
            'facility'=>'required|unique:facilities,name,' .$id. ',id',
            'type' => 'required',
        
        ]);

        $facility = Facility::where(['id'=>$id])->update([
            "name"=>$request->input('facility'),
            "type"=>$request->input('type'),
        ]);
        return $facility;
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
        $destroy = Facility::where('id',$id)->delete();
        return  $destroy;
    }
}
