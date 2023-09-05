<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\PlayList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    //profile
    public function profile(){
        return view('user.account.profile');

    }

    //get User
    public function getUser($id){
        $data=User::where('id',$id)->first();
        return response()->json($data, 200);
    }

    // updateUser
    public function updateUser(Request $req,$id){
        $data=[
            'name'=>$req->user['name'],
            'email'=>$req->user['email'],
            'gender'=>$req->user['gender'],
        ];
        if ($req->userImage!=null) {
            $dbImage=User::where('id',$id)->first()->image;
            if ($dbImage!=null) {
                Storage::delete('public/'.$dbImage);
            }
            $userImage=uniqid().$req->file('userImage')->getClientOriginalName();
            $data['image']=$userImage;
            $req->file('userImage')->storeAs('public',$userImage);
        }
        User::where('id',$id)->update($data);
        $user=User::where('id',$id)->first();
        return response()->json($user, 200);
    }

    // getUsersList
    public function getUsersList(){
        $data=User::where('role','user')->paginate(10);
        foreach ($data as $item) {
            $item['post_count']=count(Post::where('user_id',$item->id)->get());
            $item['playlist_count']=count(PlayList::where('user_id',$item->id)->get());
        }
        return response()->json($data, 200);
    }

    // getSearchUsersList
    public function getSearchUsersList($search_key){
        $data=User::where('role','user')->where('name','like','%'.$search_key.'%')->paginate(10);
        foreach ($data as $item) {
            $item['post_count']=count(Post::where('user_id',$item->id)->get());
            $item['playlist_count']=count(PlayList::where('user_id',$item->id)->get());
        }
        return response()->json($data, 200);
    }

    // changePassword
    public function changePassword(Request $req){
        $data=[
            'status'=>'success',
        ];
        if (Hash::check($req->current_password, Auth::user()->password)) {
            $hashPassword=Hash::make($req->password);
            User::where('id',Auth::user()->id)->update(['password'=>$hashPassword]);
            return response()->json($data, 200);
        }else{
            $data['status']='fail';
            return response()->json($data, 200);
        }
    }

    // changeUserPage
    public function changeUserPage(){
        Session::flush();

        return redirect('login');
    }
}
