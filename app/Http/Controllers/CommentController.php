<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    //sendComment
    public function sendComment(Request $req){
        $this->validation_check($req);
        $data=$this->change_data($req);
        if ($req->reply_id!=null) {
            $data['reply_id']=$req->reply_id;
        }
        Comment::create($data);
        return back();
    }

    //send comment user
    public function sendComment_user(Request $req){
        $data=$this->change_data($req);
        if ($req->reply_id!=null) {
            $data['reply_id']=$req->reply_id;
        }
        Comment::create($data);
        $comment=Comment::where('post_id',$req->post_id)->get();
        $info=[
            'comment'=>$comment,
            'status'=>'true',
        ];
        return response()->json($info, 200);
    }

    // private function
    // validation_check
    private function validation_check($req){
        Validator::make($req->all(),[
            'comment'=>'required',
            'user_id'=>'required',
            'post_id'=>'required',
        ])->validate();
    }

    //change data
    private function change_data($req){
        return [
            'comment'=>$req->comment,
            'user_id'=>$req->user_id,
            'post_id'=>$req->post_id,
        ];
    }
}
