<?php

namespace App\Http\Controllers;
use App\Models\Packages;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_PackageController extends Controller
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
            $data = Packages::orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function($row){
                if($row->status == '1'){
                    $type = '<span class="btn btn-xs btn-success">Active</span>';
                }else{
                    $type = '<span class="btn btn-xs btn-danger">Inactive</span>';
                }
                return $type;
            })
            ->addColumn('action', function($row){
            $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="edit_package btn btn-success btn-sm">Edit</a>  <button type="button" value="delete" class="btn btn-danger btn-sm delete-package" data-id="'.$row->id.'">Delete</button>';
                return $btn;
            })
            ->rawColumns(['status','action'])
                ->make(true);
        } 
        return view('admin.packages.index'); 
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
            'duration'=>'required|unique:package_detail,duration',
            'price'=>'required',
        ]);

        $packages = new Packages();
        $packages->duration = $request->input("duration");
        $packages->price = $request->input("price");
        $packages->status = $request->input("status");
        $result = $packages->save();
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
        $packages = Packages::where(['id'=>$id])->get();
        return $packages;
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
            'duration'=>'required|unique:package_detail,duration,' .$id. ',id',
            'price' => 'required',
        
        ]);

        $packages = Packages::where(['id'=>$id])->update([
            "duration"=>$request->input('duration'),
            "price"=>$request->input('price'),
            "status"=>$request->input('status'),
        ]);
        return $packages;
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
        $destroy = Packages::where('id',$id)->delete();
        return  $destroy;
    }
}
