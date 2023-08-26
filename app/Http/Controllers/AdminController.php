<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    // account
    //profile
    public function profile(){
        $posts=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('posts.user_id',Auth::user()->id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->orderBy('posts.created_at','desc')
        ->paginate(10);
        for ($i=0; $i < count($posts) ; $i++) {

            $like=Like::where('post_id',$posts[$i]->id)->get();
            $like_count=count($like);
            $myLike=Like::where('post_id',$posts[$i]->id)->where('user_id',Auth::user()->id)->first();

            if (isset($myLike)) {
                $posts[$i]['my_like_status']=true;
            }else{
                $posts[$i]['my_like_status']=false;
            }

            $posts[$i]['like_count']=$like_count;


        }
        return view('admin.account.profile',compact('posts'));
    }

    // profileEdit
    public function profileEdit(){
        $data=User::where('id',Auth::user()->id)->first();
        return view('admin.account.edit',compact('data'));
    }

    //profile Update
    public function profileUpdate(Request $req){
        $this->validation_check($req);
        $data=$this->change_data($req);
        if (isset($req->image)) {
            $dbImage=User::where('id',Auth::user()->id)->first()->image;
            if ($dbImage!=null) {
                Storage::delete('public/'.$dbImage);
            }
            $userImage=uniqid().$req->file('image')->getClientOriginalName();
            $data['image']=$userImage;
            $req->file('image')->storeAs('public',$userImage);
        }
        User::where('id',Auth::user()->id)->update($data);
        return redirect()->route('admin#profile')->with(['updateSucc'=>'Profile update successful.']);
    }

    //changePassword
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change password
    public function changePassword(Request $req){
        if (Hash::check($req->current_password, Auth::user()->password)) {
            $this->passwordValidation($req);
            $hashPassword=Hash::make($req->password);
            User::where('id',Auth::user()->id)->update(['password'=>$hashPassword]);
            return redirect()->route('admin#profile')->with(['changePassword'=>'Change password successful.']);
        }
        return back()->with(['incorrect'=>'Your password is incorrect.']);
    }

    // viewProfile
    public function viewProfile($id){
        $data=User::where('id',$id)->first();
        $posts=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('posts.user_id',$id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->orderBy('posts.created_at','desc')
        ->paginate(10);
        for ($i=0; $i < count($posts) ; $i++) {

            $like=Like::where('post_id',$posts[$i]->id)->get();
            $like_count=count($like);
            $myLike=Like::where('post_id',$posts[$i]->id)->where('user_id',Auth::user()->id)->first();

            if (isset($myLike)) {
                $posts[$i]['my_like_status']=true;
            }else{
                $posts[$i]['my_like_status']=false;
            }

            $posts[$i]['like_count']=$like_count;


        }
        return view('admin.account.viewProfile',compact('data','posts'));
    }

    // adminlist
    public function adminlist(){
        $data=User::where('role','admin')
        ->when(request('search_key'),function($search_item){
            $search_item->where('name','like','%'.request('search_key').'%');
        })
        ->paginate(10);
        return view('admin.account.adminList',compact('data'));
    }

    public function addAdminPage(){
        return view('admin.account.addAdmin');
    }

    public function addAdmin(Request $req){
        $this->addAccount($req);
        return redirect()->route('admin#list')->with(['createSucc'=>'Account create successful.']);
    }

    //user
    // userList
    public function userList(){
        $data=User::where('role','user')
        ->when(request('search_key'),function($search_item){
            $search_item->where('name','like','%'.request('search_key').'%');
        })
        ->paginate('10');
        for ($i=0; $i <count($data) ; $i++) {
            $post_count=count(Post::where('user_id',$data[$i]->id)->get());
            $data[$i]['post_count']=$post_count;
        }
        return view('admin.user.list',compact('data'));
    }

    // addUserPage
    public function addUserPage(){
        return view('admin.user.addUser');
    }

    //add user
    public function addUser(Request $req){
        $this->addAccount($req);
        return redirect()->route('admin#userList')->with(['createSucc'=>'Account create successful.']);
    }

    // deleteUserAccount
    public function deleteUserAccount($id){
        $this->deleteAccount($id);
        return redirect()->route('admin#userList')->with(['deleteSucc'=>'Account delete successful.']);
    }

    // private function
    // validation_check
    private function validation_check($req){
        Validator::make($req->all(),[
            'name'=>'required',
            'email'=>'required',
            'gender'=>'required',
            'role'=>'required',
            'image'=>'nullable|image'
        ])->validate();
    }

    //password validation
    private function passwordValidation($req){
        Validator::make($req->all(),[
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password|min:6',
        ])->validate();
    }

    // change data
    private function change_data($req){
        return [
            'name'=>$req->name,
            'email'=>$req->email,
            'gender'=>$req->gender,
            'role'=>$req->role,
        ];
    }

    //add account
    private function addAccount($req){
        $this->validation_check($req);
        $this->passwordValidation($req);
        $data=$this->change_data($req);
        $hashPassword=Hash::make($req->password);
        $data['password']=$hashPassword;
        if (isset($req->image)) {
            $imgName=uniqid().$req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public',$imgName);
            $data['image']=$imgName;
        }
        User::create($data);
    }

    //delete account
    private function deleteAccount($id){
        $userImage=User::where('id',$id)->first()->image;
        if(isset($userImage)){
            Storage::delete('public/'.$userImage);
        }
        User::where('id',$id)->delete();
    }

}
