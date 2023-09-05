<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\PlayList;
use App\Models\PlayListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //admin
    //postList
    public function postList(){
        $posts=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->when(request('search_key'),function($search_item){
            $search_item->where('posts.Title','like','%'.request('search_key').'%');
        })
        ->when(request('trendPost'),function($search_item){
            $search_item->orderBy('view_count','desc');
        })
        ->when(request('category_id'),function($search_item){
            $search_item->where('posts.category_id',request('category_id'));
        })
        ->paginate(20);
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

        $categories=Category::get();
        return view('admin.post.list',compact('posts','categories'));
    }

    //add Post page
    public function addPostPage(){
        $categories=Category::get();
        $playLists=PlayList::where('user_id',Auth::user()->id)->get();
        return view('admin.post.addPost',compact('categories','playLists'));
    }

    //addPost
    public function addPost(Request $req){
        $this->validation_check($req);
        $data=$this->changeData($req);
        if (isset($req->image)) {
            $imgName=uniqid().$req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public/'.$imgName);
            $data['image']=$imgName;
        }
        $post=Post::create($data);
        return redirect()->route('admin#profile')->with(['createPostSucc'=>'Post create successful.']);

    }

    // viewPost
    public function viewPost($id){

        $post=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('posts.id',$id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->first();

        $currentPost=Post::where('id',$id)->first();
        $playListItem=null;
        if ($currentPost->playlist_id!=null) {
            $playListItem=Post::where('playlist_id',$currentPost->playlist_id)->get();
        }
        $like=Like::where('post_id',$id)->get();
        $post['like_count']=count($like);
        $post['my_like_status']=false;
        for ($i=0; $i < count($like); $i++) {
            if ($like[$i]->user_id==Auth::user()->id) {
                $post->my_like_status=true;
            }
        }
        $relatedPost=Post::select('posts.*','users.name as user_name')
        ->leftJoin('users','posts.user_id','users.id')
        ->where('category_id',$currentPost->category_id)->get();

        $comments=Comment::select('comments.*','users.name as user_name')
        ->leftJoin('users','comments.user_id','users.id')
        ->where('post_id',$currentPost->id)->get();

        return view('admin.post.viewPost',compact('post','playListItem','relatedPost','comments'));
    }

    // editPost
    public function editPost($id){
        $post=Post::where('id',$id)->first();
        $categories=Category::get();
        $playLists=PlayList::where('user_id',Auth::user()->id)->get();
        return view('admin.post.editPost',compact('post','categories','playLists'));
    }

    //update post
    public function updatePost(Request $req,$id){
        $this->validation_check($req);
        $data=$this->changeData($req);
        $post=Post::where('id',$id)->first();
        if (isset($req->image)) {
            if ($post->image!=null) {
                Storage::delete('public/'.$post->image);
            }
            $imgName=uniqid().$req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public/'.$imgName);
            $data['image']=$imgName;
        }
        Post::where('id',$id)->update($data);
        return  redirect()->route('admin#viewPost',$id)->with(['updatePostSucc'=>'Post update successful.']);
    }

    //delete post
    public function deletePost($id){
        $postImage=Post::where('id',$id)->first()->image;
        if ($postImage!=null) {
            Storage::delete('public/'.$postImage);
        }
        Post::where('id',$id)->delete();
        return redirect()->route('admin#profile')->with(['deletePostSucc'=>'Post delete successful.']);
    }

    //user
    // getPost_user
    public function getPost_user(){
        $data=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->paginate(10);
        return response()->json($data, 200);
    }

    // getPostCategory_user
    public function getPostCategory_user($id){
        $data=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('posts.category_id',$id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->paginate(10);
        return response()->json($data, 200);
    }

    // getPostCategory_user
    public function getPostSearch_user($search_key){
        logger($search_key);
        $data=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('posts.Title','like','%'.$search_key.'%')
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->paginate(10);
        return response()->json($data, 200);
    }

    //get my post
    public function getMyPost($id){
        $data=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('posts.user_id',$id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')->paginate(10);
        return response()->json($data, 200);
    }

    // editPost_user
    public function editPost_user($id){
        $post=Post::where('id',$id)->first();
        $categories=Category::get();
        $playLists=PlayList::where('user_id',Auth::user()->id)->get();
        $data=[
            'post' => $post,
            'categories' => $categories,
            'playLists' => $playLists,
        ];
        return response()->json($data, 200);
    }

    // updatePost_user
    public function updatePost_user(Request $req){
        $data=[
            'Title'=>$req->Title,
            'user_id'=>$req->user_id,
            'category_id'=>$req->category_id,
            'content'=>$req->content,
            'playlist_id'=>$req->playlist_id,
        ];
        $post=Post::where('id',$req->id)->first();
        if (isset($req->updateImage)) {
            if ($post->image!=null) {
                Storage::delete('public/'.$post->image);
            }
            $imgName=uniqid().$req->file('updateImage')->getClientOriginalName();
            $req->file('updateImage')->storeAs('public/'.$imgName);
            $data['image']=$imgName;
        }
        Post::where('id',$req->id)->update($data);
        $info=[
            'status'=>true,
        ];
        return response()->json($info, 200);
    }

    //postUpdate_user
    public function addPost_user(Request $req){
        $postData=$this->changeData($req);
        if (isset($req->image)) {
            $imgName=uniqid().$req->file('image')->getClientOriginalName();
            $req->file('image')->storeAs('public/'.$imgName);
            $postData['image']=$imgName;
        }
        $post=Post::create($postData);
        $data=[
            'status'=>true,
            'post'=>$post,
        ];
        return response()->json($data, 200);
    }

    // viewPost_user
    public function viewPost_user($id){
        $post=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('posts.id',$id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->first();

        $currentPost=Post::where('id',$id)->first();
        $playListItem=null;
        if ($currentPost->playlist_id!=null) {
            $playListItem=Post::where('playlist_id',$currentPost->playlist_id)->get();
        }

        $like=Like::where('post_id',$id)->get();
        $post['like_count']=count($like);
        $post['my_like_status']=false;
        for ($i=0; $i < count($like); $i++) {
            if ($like[$i]->user_id==Auth::user()->id) {
                $post->my_like_status=true;
            }
        }

        $relatedPost=Post::select('posts.*','users.name as user_name')
        ->leftJoin('users','posts.user_id','users.id')
        ->where('category_id',$currentPost->category_id)->get();
        $comments=Comment::where('post_id',$currentPost->id)->get();

        $data=[
            'post'=>$post,
            'playListItem'=>$playListItem,
            'relatedPost'=>$relatedPost,
            'comments'=>$comments,
        ];
        return response()->json($data, 200);
    }

    // private function
    //validation check
    private function validation_check($req){
        Validator::make($req->all(),[
            'title'=>'required',
            'user_id'=>'required',
            'content'=>'required',
        ])->validate();
    }

    //change data
    private function changeData($req){
        return [
            'Title'=>$req->title,
            'user_id'=>$req->user_id,
            'category_id'=>$req->category_id,
            'content'=>$req->content,
            'playlist_id'=>$req->playlist_id,
        ];
    }
}
