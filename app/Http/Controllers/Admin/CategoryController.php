<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'categories' =>$categories 
        ], 200);
    }

    public function indexActive()
    {
        $categories = Category::where('status',1)->get();
        return response()->json([
            'categories' =>$categories 
        ], 200);
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
        $request->validate([
            'name'=>'required',
            'status'=>'required',
        ]);
        
        Category::create([
            'name'=>$request->name,
            'slug'=>slugify($request->name),
            'status'=>$request->status,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $category = Category::where('slug',$slug)->first();
        return response()->json([
            'category' =>$category
        ], 200);
    }
    public function removeItems(Request $request)
    {
        $getid = $request->ids;
        $a=0;
        foreach ($getid as $key => $value) {
            $a++;
            Category::where('id', '=',$value)->delete();
        }
        $totaldel = $a;
        return response()->json([
            'totaldel' =>$totaldel
        ], 200);
    }

    public function changeStatus(Request $request)
    {
        $getid = $request->ids;
        $act = $request->val;
        $a=0;
        foreach ($getid as $key => $value) {
            $a++;
             Category::where('id', $value)->update([
                
                'status'=>$act
    
    
            ]);
        }
        $totaldel = $a;
        if ($act==0) {
            return response()->json([
                'totaldel' =>$totaldel,
                'act' =>"InActive"
            ], 200);
        }elseif($act==1){

            return response()->json([
                'totaldel' =>$totaldel,
                'act' =>"Activate"
            ], 200);
        }
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
        $request->validate([
            'name'=>'required',
            'status'=>'required',
        ]);
        
        $upcat =  Category::where('id', $request->id)->update([
            'name'=>$request->name,
            'slug'=>slugify($request->name),
            'status'=>$request->status


        ]);
        if ($upcat) {
            $success = true;
        }else{
            $success = false;
        }
        return response()->json([
            'success' =>$success
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $del = Category::find($id);
        // $del->delete();
      Category::where('slug', '=',$id)->delete();
  
        
    }
}
