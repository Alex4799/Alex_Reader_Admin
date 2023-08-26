<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PlayList;
use App\Models\PlayListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PlayListController extends Controller
{
    //list
    public function playList(){
        $data=PlayList::where('user_id',Auth::user()->id)
        ->when(request('search_key'),function($search_item){
            $search_item->where('name','like','%'.request('search_key').'%');
        })
        ->paginate(10);
        return view('admin.playlist.list',compact('data'));
    }

    // playlistAddpage
    public function playlistAddpage(){
        return view('admin.playlist.addPlaylist');
    }

    //playlistAdd
    public function playlistAdd(Request $req){
        $this->validation_check($req);
        $data=$this->change_data($req);
        PlayList::create($data);
        return redirect()->route('admin#playlist')->with(['createSucc'=>'Playlist create successful.']);
    }

    //playlistEdit
    public function playlistEdit($id){
        $playList=PlayList::where('id',$id)->first();
        return view('admin.playlist.editPlaylist',compact('playList'));
    }

    // playlist update
    public function playlistUpdate(Request $req,$id){
        $this->validation_check($req);
        PlayList::where('id',$id)->update(['name'=>$req->name]);
        return redirect()->route('admin#playlist')->with(['updateSucc'=>'Playlist update successful.']);
    }

    //playlist Delete
    public function playlistDelete($id){
        Post::where('playlist_id',$id)->update(['playlist_id'=>null]);
        PlayList::where('id',$id)->delete();
        return redirect()->route('admin#playlist')->with(['deleteSucc'=>'Playlist delete successful.']);
    }

    //playlist Item
    public function playlistItem($id){
        $playList=PlayList::where('id',$id)->first();
        $posts=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('playlist_id',$id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->when(request('search_key'),function($search_item){
            $search_item->where('posts.Title','like','%'.request('search_key').'%');
        })
        ->paginate(20);
        return view('admin.playlist.playlistItem',compact('posts','playList'));
    }

    // addPlaylistItemPage
    public function addPlaylistItemPage($playlist_id){
        $playList=PlayList::where('id',$playlist_id)->first();
        $posts=Post::select('posts.*','categories.name as category_name','users.name as user_name')
        ->where('posts.user_id',Auth::user()->id)
        ->where('playlist_id',null)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->when(request('search_key'),function($search_item){
            $search_item->where('posts.Title','like','%'.request('search_key').'%');
        })
        ->paginate(20);
        return view('admin.playlist.addPlaylistItem',compact('posts','playList'));
    }

    // addPlaylistItem
    public function addPlaylistItem($post_id,$playlist_id){
        Post::where('id',$post_id)->update(['playlist_id'=>$playlist_id]);
        return back()->with(['addSuccess'=>'Add to playlist successful']);
    }

    // removePlaylistItem
    public function removePlaylistItem($post_id){
        Post::where('id',$post_id)->update(['playlist_id'=>null]);
        return back()->with(['removeSucc'=>'Remove from playlist successful']);

    }

    // user
    // getPlaylist_user
    public function getMyPlaylist_user($id){
        $data=PlayList::where('user_id',$id)->get();
        return response()->json($data, 200);
    }

    public function getSearchPlaylist_user(Request $req){
        $data=PlayList::where('user_id',$req->id)->where('name','like','%'.$req->searchKey.'%')->get();
        return response()->json($data, 200);
    }

    // getPlaylistPost
    public function getPlaylistPost($id){
        $post=Post::where('playlist_id',$id)->get();
        $data=count($post);
        return response()->json($data, 200);
    }

    // addPlaylist_user
    public function addPlaylist_user(Request $req){
        $playlist=$this->change_data($req);
        PlayList::create($playlist);
        $data=[
            'status'=>true
        ];
        return response()->json($data, 200);
    }

    // editPlaylist_user
    public function editPlaylist_user($playlist_id){
        $data=PlayList::where('id',$playlist_id)->first();
        return response()->json($data, 200);
    }

    // updatePlaylist_user
    public function updatePlaylist_user(Request $req){
        $post=$this->change_data($req);
        PlayList::where('id',$req->id)->update($post);
        $data=[
            'status'=>true
        ];
        return response()->json($data, 200);
    }

    // getPlaylistItem_user
    public function getPlaylistItem_user($id){
        $playList=PlayList::where('id',$id)->first();
        $posts=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('playlist_id',$id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->get();
        $data=[
            'playlist'=>$playList,
            'posts'=>$posts,
        ];
        return response()->json($data, 200);
    }

    // removePlaylistItem_user
    public function removePlaylistItem_user($post_id,$playlist_id){
        Post::where('id',$post_id)->update(['playlist_id'=>null]);
        $posts=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('playlist_id',$playlist_id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->get();
        $data=[
            'posts'=>$posts,
        ];
        return response()->json($data, 200);
    }

    // addPlayListItemGetData_user
    public function addPlayListItemGetData_user($playlist_id){
        $playList=PlayList::where('id',$playlist_id)->first();
        $posts=Post::select('posts.*','categories.name as category_name','play_lists.name as playlist_name','users.name as user_name')
        ->where('playlist_id',null)
        ->where('posts.user_id',Auth::user()->id)
        ->leftJoin('categories','posts.category_id','categories.id')
        ->leftJoin('play_lists','posts.playlist_id','play_lists.id')
        ->leftJoin('users','posts.user_id','users.id')
        ->get();
        $data=[
            'playlist'=>$playList,
            'posts'=>$posts,
        ];
        return response()->json($data, 200);
    }

    // addPlaylistItem_user
    public function addPlaylistItem_user($post_id,$playlist_id){
        Post::where('id',$post_id)->update(['playlist_id'=>$playlist_id]);
        return redirect()->route('user#addPlayListItemGetData',$playlist_id);
    }

    // deletePlaylist
    public function deletePlaylist($id){
        Post::where('playlist_id',$id)->update(['playlist_id'=>null]);
        PlayList::where('id',$id)->delete();
        return redirect()->route('user#getMyPlaylist',Auth::user()->id);
    }

    // private function
    private function validation_check($req){
        Validator::make($req->all(),[
            'name'=>'required',
            'user_id'=>'required'
        ])->validate();
    }

    private function change_data($req){
        return [
            'name'=>$req->name,
            'user_id'=>$req->user_id
        ];
    }
}
