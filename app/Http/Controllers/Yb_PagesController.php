<?php

namespace App\Http\Controllers;
use App\Models\Pages;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_PagesController extends Controller
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
            $data = Pages::orderBy('page_id','desc')->get();
                return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="pages/'.$row->page_id.'/edit" class="btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-page btn btn-danger btn-sm" data-id="'.$row->page_id.'">Delete</a>';
                    return $btn;
                })
                ->editColumn('show_in_header', function($row){
                    $checked = ($row->show_in_header == '1') ? 'checked' : '';
                    return '<div class="page-checkbox">
                    <input type="checkbox" class="show-in-header" id="head'.$row->page_id.'" '.$checked.'>
                    <label for="head'.$row->page_id.'"></label>
                </div>';
                })
                ->editColumn('show_in_footer', function($row){
                    $checked = ($row->show_in_footer == '1') ? 'checked' : '';
                    return '<div class="page-checkbox">
                    <input type="checkbox" class="show-in-footer" id="foot'.$row->page_id.'" '.$checked.'>
                    <label for="foot'.$row->page_id.'"></label>
                </div>';
                })
                ->editColumn('status', function($row){
                    if($row->status == '1'){
                        $status = '<span class="badge badge-success">Active</span>';
                    }else{
                        $status = '<span class="badge badge-danger">Inactive</span>';
                    }
                    return $status;
                })
                ->rawColumns(['show_in_header','show_in_footer','action','status'])
                ->make(true);
        }
        return view('admin.pages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.pages.create');
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
        $request->validate(['title'=>'required']);

        $pages = new Pages();
        $pages->page_title = $request->input("title");
        $pages->slug = str_replace(array(' ','_'),'-',strtolower($request->input("title")));
        $pages->description = htmlspecialchars($request->input("description"));
        $result =  $pages->save();
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
        $pages = Pages::where(['page_id'=>$id])->first();
        return view('admin.pages.edit',['pages'=>$pages]);
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
            'title'=>'required',
            'status' => 'required',
        ]);

        if($request->slug != ''){
            $slug = str_replace(array(' ','_'),'-',strtolower($request->input("slug")));
        }else{
            $slug = str_replace(array(' ','_'),'-',strtolower($request->input("title")));
        }

        $pages = Pages::where(['page_id'=>$id])->update([
                "page_title"=>$request->input('title'),
                "slug"=>$slug,
                "description" => htmlspecialchars($request->input("description")),
                "status"=>$request->input('status'),
        ]);
            return $pages;
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
        $destroy = Pages::where('page_id',$id)->delete();
        return  $destroy;
    }


    public function yb_show_in_header(Request $request){
        $id = $request->id;
        $status = $request->status;

        $response = Pages::where('page_id',$id)->update([
            'show_in_header'=> $status
        ]);
        return $response;
    }

    public function yb_show_in_footer(Request $request){
        $id = $request->id;
        $status = $request->status;

        $response = Pages::where('page_id',$id)->update([
            'show_in_footer'=> $status
        ]);
        return $response;
    }
}
