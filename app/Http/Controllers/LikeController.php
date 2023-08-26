<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //set like
    public function setLike($post_id){
        // dd($post_id);
        $post=Like::where('post_id',$post_id)->where('user_id',Auth::user()->id)->first();
        if (isset($post)) {
            Like::where('post_id',$post_id)->where('user_id',Auth::user()->id)->delete();
        }else{
            Like::create([
                'user_id'=>Auth::user()->id,
                'post_id'=>$post_id,
            ]);
        }
        return back();

    }

    public function setLike_user($post_id){
        $post=Like::where('post_id',$post_id)->where('user_id',Auth::user()->id)->first();
        if (isset($post)) {
            Like::where('post_id',$post_id)->where('user_id',Auth::user()->id)->delete();
        }else{
            Like::create([
                'user_id'=>Auth::user()->id,
                'post_id'=>$post_id,
            ]);
        }
        return redirect("http://localhost:8000/api/user/post/view/$post_id");
    }
}
