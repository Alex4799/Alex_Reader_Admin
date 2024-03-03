@extends('admin.main.main')

@section('title')
    Edit Post
@endsection

@section('contect')
    <div class="container py-5">
        <h1 class=" text-center">Edit Post</h1>
        <form action="{{route('admin#updatePost',$post->id)}}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="user_id" value="{{Auth::user()->id}}">

            <div class="shadow p-5 row">
                <div class="col-lg-4">
                    <div>
                        @if ($post->image!=null)
                            <img src="{{asset('storage/'.$post->image)}}" class="w-75 shadow">
                        @else
                            <img src="{{asset('image/default.png')}}" class="w-75 shadow">
                        @endif

                        <input name="image" type="file" class="form-control my-4 @error('image') is-invalid @enderror">
                        @error('image')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-8">

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Title</label>
                        <div class="col-sm-9">
                        <input name="title" value="{{$post->Title}}" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                        @error('title')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Category</label>
                        <div class="col-sm-9">
                        <select name="category_id" class="form-control @error('category_id') is-invalid @enderror">
                            <option value="">Choose Category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" @if ($post->category_id==$category->id) selected @endif >{{$category->name}}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">PlayList</label>
                        <div class="col-sm-9">
                            <select name="playlist_id" class="form-control">
                                <option value="">Null</option>
                                @foreach ($playLists as $playlist)
                                    <option value="{{$playlist->id}}" @if ($post->playlist_id==$playlist->id) selected @endif>{{$playlist->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <textarea name="content" id="editor" placeholder="Enter Your Contect" class="form-control @error('description') is-invalid @enderror" cols="30" rows="10">{{$post->content}}</textarea>
                        @error('content')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="float-end">
                        <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-upload me-2"></i>Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection
