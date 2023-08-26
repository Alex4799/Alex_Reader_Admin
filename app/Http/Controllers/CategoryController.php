<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //categoryList
    public function categoryList(){
        $data=Category::when(request('search_key'),function($search_item){
            $search_item->where('name','like','%'.request('search_key').'%');
        })
        ->paginate(10);
        return view('admin.category.list',compact('data'));
    }

    //categoryAddpage
    public function categoryAddpage(){
        return view('admin.category.addCategory');
    }

    // categoryAdd
    public function categoryAdd(Request $req){
        $this->validation_check($req);
        $data=$this->change_data($req);
        Category::create($data);
        return redirect()->route('admin#categoryList')->with(['createSucc'=>'Category create successful.']);
    }

    // categoryEdit
    public function categoryEdit($id){
        $data=Category::where('id',$id)->first();
        return view('admin.category.editCategory',compact('data'));
    }

    //category update
    public function categoryUpdate(Request $req,$id){
        $this->validation_check($req);
        Category::where('id',$id)->update(['name'=>$req->name]);
        return redirect()->route('admin#categoryList')->with(['updateSucc'=>'Category update successful.']);
    }

    // categoryDelete
    public function categoryDelete($id){
        Post::where('category_id',$id)->update(['category_id'=>null]);
        Category::where('id',$id)->delete();
        return redirect()->route('admin#categoryList')->with(['deleteSucc'=>'Category delete successful.']);
    }

    // user
    //get category user
    public function getCategory_user(){
        $data=Category::get();
        return response()->json($data, 200);
    }

    // addCategory_user
    public function addCategory_user(Request $req){
        $data=$this->change_data($req);
        Category::create($data);
        $status=[
            'status'=>true
        ];
        return response()->json($status, 200);
    }

    // getCategoryItem_user
    public function getCategoryItem_user($id){
        $data=Category::where('id',$id)->first();
        return response()->json($data, 200);
    }

    // updateCategory_user
    public function updateCategory_user(Request $req){
        $data=$this->change_data($req);
        Category::where('id',$req->id)->update($data);
        $status=[
            'status'=>true
        ];
        return response()->json($status, 200);
    }

    // deleteCategory_user
    public function deleteCategory_user($id){
        Category::where('id',$id)->delete();
        $data=Category::get();
        return response()->json($data, 200);
    }

    // searchCategory_user
    public function searchCategory_user($search_key){
        $data=Category::where('name','like','%'.$search_key.'%')->get();
        return response()->json($data, 200);
    }

    // private function
    private function validation_check($req){
        Validator::make($req->all(),[
            'name'=>'required',
        ])->validate();
    }

    private function change_data($req){
        return [
            'name'=>$req->name,
        ];
    }
}
?>
