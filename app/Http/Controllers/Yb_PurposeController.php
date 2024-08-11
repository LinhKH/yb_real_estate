<?php

namespace App\Http\Controllers;
use App\Models\Purpose;
use App\Models\Property;
use Yajra\DataTables\DataTables;


use Illuminate\Http\Request;

class Yb_PurposeController extends Controller
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
            $data = Purpose::orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function($row){
                if($row->status == '1'){
                    $status = '<span class="btn btn-xs btn-success">Active</span>';
                }else{
                    $status = '<span class="btn btn-xs btn-danger">Inactive</span>';
                }
                return $status;
            })
            ->addColumn('action', function($row){
            $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="edit_purpose btn btn-success btn-sm">Edit</a>  <button type="button" value="delete" class="btn btn-danger btn-sm delete-purpose" data-id="'.$row->id.'">Delete</button>';
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        } 
        return view('admin.purpose.index'); 
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
        $request->validate(['purpose'=>'required|unique:purpose,name',]);

        $purpose = new Purpose();
        $purpose->name = $request->input("purpose");
        $result = $purpose->save();
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
        $purpose = Purpose::where(['id'=>$id])->get();
        return $purpose;
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
            'purpose'=>'required|unique:purpose,name,' .$id. ',id',
            'status' => 'required',
        ]);

        $purpose = Purpose::where(['id'=>$id])->update([
            "name"=>$request->input('purpose'),
            "status"=>$request->input('status'),
        ]);
        return $purpose;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Property::where('purpose','=',$id)->count();
        if($check == '0'){
            $destroy = Purpose::where('id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't delete this (This Purpose is used in Properties List.)";
        }
        
    }
}
