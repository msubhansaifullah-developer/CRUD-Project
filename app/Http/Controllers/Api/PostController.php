<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class PostController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts']=Post::all();
        // return response()->json([
        //     'status'=>true,
        //     'message'=>'All post data',
        //     'data'=>$data,
        // ],200);
        return $this->sendresponse($data,'All post data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateUser=Validator::make($request->all(),
        [
            'title'=>'required',
            'description'=>'required',
            'image'=>'mimes:png,jpg,jpeg,gif,webp'
        ]);
        if($validateUser->fails()){
            // return response()->json([
            //     'status'=>false,
            //     'message'=>'validation Error',
            //     'errors'=>$validateUser->errors()->all()
            // ],401);

             return $this->senderror('validation Error',$validateUser->errors()->all());
        }
        $img=$request->file('image');
        $ext=$img->getClientOriginalExtension();
        $imagename=time(). '.' . $ext;
        $imagepath= $img->storeAs('images',$imagename,'public');
        $post=Post::create([
            'title'=>$request->title,
            'description'=>$request->description,
             'image'=>$imagepath,
        ]);
     
        //  return response()->json([
        //         'status'=>true,
        //         'message'=>'post created successfully',
        //         'user'=>$post,
        //     ],200);
         return $this->sendresponse($post,'All post data');
   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post']=Post::select('id','title','description','image')->where(['id'=>$id])->get();

        //  return response()->json([
        //         'status'=>true,
        //         'message'=>'your single Post',
        //         'user'=>$data,
        //     ],200);

         return $this->sendresponse($data,'your single post data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $validateUser=Validator::make($request->all(),
        [
             'title'=>'required',
             'description'=>'required',
            'image'=>' nullable|mimes:png,jpg,jpeg,gif,webp'
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status'=>false,
                'message'=>'validation Error',
                'errors'=>$validateUser->errors()->all()
            ],401);

             return $this->senderror('validation Error',$validateUser->errors()->all());
       } 
         $post = Post::findOrFail($id);

        if($request->image!='' ){
            $path=public_path().'/uploads';
            if($post->image!=' ' && $post->image!=null){
                $old_file=$path.$post->image;
                if(file_exists($old_file)){
                    unlink($old_file);
                }
            }
             $img=$request->file('image');
             $ext=$img->getClientOriginalExtension();
            $imagename=time(). '.' . $ext;
            $imagepath=$img->storeAs('images',$imagename,'public');
            
        }else{
             $imagename=$post->image; 
        }
       
        
        $post=Post::where(['id'=>$id])->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$imagepath,
        ]);

        //  return response()->json([
        //         'status'=>true,
        //         'message'=>'post updated successfully',
        //         'user'=>$post,
        //     ],200);

         return $this->sendresponse($post,'All post data');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
  {
    $post = Post::find($id);

    if (!$post) {
        return response()->json(['message' => 'Post not found'], 404);
    }

    if ($post->image) {
        $filepath = storage_path('app/public/' . $post->image);

        if (file_exists($filepath)) {
            unlink($filepath);
        }
    }

    $post->delete();

    return $this->sendresponse(true, 'Your post has been removed');
}

}
