<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // login page
    public function loginPage(){
        return view('auth.login');
    }

    // register page
    public function registerPage(){
        return view('auth.register');
    }

    //dashboard
    public function dashboard(){
        if (Auth::user()->role=='admin') {

            return redirect()->route('admin#profile');

        } else if(Auth::user()->role=='user'){

            return redirect()->route('user#profile');

        }

    }

    public function changeRole($id,$status){
        if ($status==1) {
            $status='admin';
        }else{
            $status='user';
        }
        User::where('id',$id)->update(['role'=>$status]);
        return back();
    }

    //login_user
    public function login_user(Request $req){
        $user=User::where('email',$req->email)->first();
        $data;

        if (isset($user)) {
            if (Hash::check($req->password, $user->password)) {
                $data=[
                    'user'=>$user,
                    'token'=>$user->createToken(time())->plainTextToken,
                    'message'=>'Login Success',
                ];
            }else{
                $data=[
                    'user'=>null,
                    'token'=>null,
                    'message'=>'Incorrect Password',
                ];
            }
        }else{
            $data=[
                'user'=>null,
                'token'=>null,
                'message'=>'User Not found',
            ];
        }
        return response()->json($data, 200);
    }

    //register
    public function register_user(Request $req){
        $user=[
            'name'=>$req->name,
            'email'=>$req->email,
            'gender'=>'male',
            'password'=>Hash::make($req->password),
        ];
        $account=User::create($user);
        $data=[
            'user'=>$account,
            'token'=>$account->createToken(time())->plainTextToken,
            'message'=>'Account create successful',
        ];

        return response()->json($data, 200);

    }
}
