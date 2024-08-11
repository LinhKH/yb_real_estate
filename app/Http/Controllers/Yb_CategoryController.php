<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Property;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_CategoryController extends Controller
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
            $data = Category::orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('cat_image', function($row){
                if($row->cat_image != ''){
                    $image = '<img src="'.asset('public/category/'.$row->cat_image).'" width="100px">';
                }else{
                    $image = '<img src="'.asset('public/category/default.png').'" width="100px">';
                }
                return $image;
            })
            ->editColumn('status', function($row){
                if($row->status == '1'){
                    $status = '<span class="btn btn-xs btn-success">Active</span>';
                }else{
                    $status = '<span class="btn btn-xs btn-danger">Inactive</span>';
                }
                return $status;
            })
            ->addColumn('action', function($row){
            $btn = '<a href= "javascript:void(0)" data-id="'.$row->id.'" class="edit_category btn btn-success btn-sm">Edit</a>  <button type="button" value="delete" class="btn btn-danger btn-sm delete-category" data-id="'.$row->id.'">Delete</button>';
                return $btn;
            })
            ->rawColumns(['cat_image','status','action'])
            ->make(true);
        } 
        return view('admin.category.index'); 
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
            'category'=>'required|unique:category,category_name',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if($request->image){
            $image = $request->image->getClientOriginalName();
            $request->image->move(public_path('category'),$image);
        }else {
            $image = "";
        }

        $slug = str_replace(array('_',' ',),'-',strtolower($request->input("category")));

        $category = new Category();
        $category->category_name = $request->input("category");
        $category->cat_slug = $slug;
        $category->cat_image = $image;
        $result = $category->save();
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
        $category = Category::where(['id'=>$id])->first();
        return $category;
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
            'category'=>'required|unique:category,category_name,' .$id. ',id',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required',
        ]);

        if($request->image != ''){        
            $path = public_path().'/category/';
            //code for remove old file
            if($request->old_image != ''  && $request->old_image != null){
                $file_old = $path.$request->old_image;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->image;
            $image = $request->image->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $request->old_image;
        }

        if($request->slug != ''){
            $slug = str_replace(array('_',' ',),'-',strtolower($request->input("slug")));
        }else{
            $slug = str_replace(array('_',' ',),'-',strtolower($request->input("category")));
        }

        $category = Category::where(['id'=>$id])->update([
            "category_name"=>$request->input('category'),
            "cat_slug"=>$slug,
            "cat_image"=>$image,
            "status"=>$request->input('status'),
        ]);
        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Property::where('category','=',$id)->count();
        if($check == 0){
            $destroy = Category::where('id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't Delete this (This Category Contains Propery List.)";
        }
        
    }
}
