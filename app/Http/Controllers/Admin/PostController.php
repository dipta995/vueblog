<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('category','user')->get();
        return response()->json([
            'posts' =>$posts 
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
            'category_id'=>'required',
            'title'=>'required',
            'content'=>'required',
         //,.'thumbnail'=>'required',
     
            'status'=>'required',
        ]);
        $string = explode(';',$request->thumbnail);
        $file = explode('/',$string[0]);
        $file_type = end($file);

   $file_name = time().'.'.$file_type;
   $status = $request->status;
   if ($status==0)
    {
       $st = "Draft";
   }else{
    $st = "Published";
   }
        $success= Post::create([
            'category_id'=>$request->category_id,
            'user_id'=>Auth::user()->id,
            'title'=>$request->title,
            'slug'=>slugify($request->title),
            'content'=>$request->content,
             'thumbnail'=>$file_name,
            'status'=>$st,
        ]);
        if ($success) {
 
    $img = Image::make($request->thumbnail)->resize(500, 250)->save(public_path('uploads/photos/'.$file_name));

    //return $img->response('jpg');
 
        }
         
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug',$slug)->first();
        return response()->json([
            'post' =>$post
        ], 200);
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
    public function removeItems(Request $request)
    {
        $getid = $request->ids;
        $a=0;
        foreach ($getid as $key => $value) {
            $a++;
            $getpost = Post::where('id', '=',$value)->first();
            $filename = $getpost->thumbnail;
 
            if($getpost->delete()){
                if (file_exists(public_path('uploads/photos'.$filename))) {
                    @unlink('uploads/photos'.$filename);
                }
            }

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
             Post::where('id', $value)->update([
                
                'status'=>$act
    
    
            ]);
        }
        $totaldel = $a;
        if ($act=='draft') {
            return response()->json([
                'totaldel' =>$totaldel,
                'act' =>"Draft"
            ], 200);
        }elseif($act=='published'){

            return response()->json([
                'totaldel' =>$totaldel,
                'act' =>"Published"
            ], 200);
        }
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $getpost  = Post::where('slug', '=',$id)->first();
        $filename = $getpost->thumbnail;
        $filename = public_path('uploads/photos'. $filename);
            if($getpost->delete()){
                if (file_exists($filename)) {
                    @unlink($filename);
                }
    }

    
}
}
