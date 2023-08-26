<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    // admin
    //messageList
    public function messageList($status){
        if ($status=='receive') {
            $data=Message::where('receive_email',Auth::user()->email)->paginate(10);
        }else{
            $data=Message::where('sent_email',Auth::user()->email)->paginate(10);
        }
        return view('admin.message.list',compact('data','status'));
    }

    // sendMessagePage
    public function sendMessagePage($reply_id){
        if ($reply_id!=0) {
            $email=Message::where('id',$reply_id)->first()->receive_email;
        }else{
            $email=Message::where('id',$reply_id)->first();
        }
        return view('admin.message.addMessage',compact('reply_id','email'));
    }

    // sendMessage
    public function sendMessage(Request $req){
        $this->validationCheck($req);
        $data=$this->changeDataType($req);
        // dd($data);
        Message::create($data);
        return redirect()->route('admin#messageList','receive');
    }

    //viewMessage
    public function viewMessage($id){
        $message=Message::where('id',$id)->first();
        if ($message->receive_email==Auth::user()->email) {
            Message::where('id',$id)->update(['status'=>1]);
        }
        if($message->reply_id!=0){
            $message=Message::where('id',$message->reply_id)->first();
        }
        $reply_message=Message::where('reply_id',$message->id)->get();
        return view('admin.message.viewMessage',compact('message','reply_message'));
    }

    //user

    // messageList_user
    public function messageList_user($email,$status){
        if ($status=='receive') {
            $data=Message::where('receive_email',$email)->get();
        }else{
            $data=Message::where('sent_email',$email)->get();
        }
        return response()->json($data, 200);
    }

    //searchMessageList_user
    public function searchMessageList_user(Request $req){
        if ($req->status=='receive') {
            $data=Message::where('receive_email',$req->email)->where('title','like','%'.$req->search_key.'%')->get();
        }else{
            $data=Message::where('sent_email',$req->email)->where('title','like','%'.$req->search_key.'%')->get();
        }
        return response()->json($data, 200);
    }

    // getReplyEmail_user
    public function getReplyEmail_user($reply_id){
        $email=Message::where('id',$reply_id)->first()->receive_email;
        return response()->json($email, 200);
    }

    // sendMessage_user
    public function sendMessage_user(Request $req){
        $data=$this->changeDataType($req);
        Message::create($data);
        $sendData=[
            'status'=>'success',
        ];
        return response()->json($sendData, 200);
    }

    // viewMessage_user
    public function viewMessage_user($id){
        $message=Message::where('id',$id)->first();
        if ($message->receive_email==Auth::user()->email) {
            Message::where('id',$id)->update(['status'=>1]);
        }
        if($message->reply_id!=0){
            $message=Message::where('id',$message->reply_id)->first();
        }
        $reply_message=Message::where('reply_id',$message->id)->get();
        $data=[
            'message'=>$message,
            'reply_message'=>$reply_message,
        ];
        return response()->json($data, 200);
    }

    // private
    // validationCheck
    private function validationCheck($req){
        Validator::make($req->all(),[
            'receive_email'=>'required',
            'title'=>'required',
            'content'=>'required',

        ])->validate();
    }

    // change data type
    private function changeDataType($req){
        return [
            'title'=>$req->title,
            'sent_email'=>$req->sent_email,
            'receive_email'=>$req->receive_email,
            'content'=>$req->content,
            'reply_id'=>$req->reply_id,
        ];
    }
}
