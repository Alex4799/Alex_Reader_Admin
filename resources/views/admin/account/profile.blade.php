@extends('admin.main.main')

@section('title')
    Profile
@endsection

@section('contect')
    <div class="container py-5">
        <h1 class="text-center">Profile</h1>
        <div class="p-3 shadow">

            @if (session('updateSucc'))
            <div class="alert alert-success alert-dismissible fade show col-4 offset-8" role="alert">
                {{session('updateSucc')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('deletePostSucc'))
            <div class="alert alert-danger alert-dismissible fade show col-4 offset-8" role="alert">
                {{session('deletePostSucc')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('createPostSucc'))
            <div class="alert alert-success alert-dismissible fade show col-4 offset-8" role="alert">
                {{session('createPostSucc')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if (session('changePassword'))
            <div class="alert alert-success alert-dismissible fade show col-4 offset-8" role="alert">
                {{session('changePassword')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="row">
                <div class="col-lg-3">
                    @if (Auth::user()->image==null)
                    @if (Auth::user()->gender=='male')
                        <img src="{{asset('image/default-male-image.png')}}" class=" w-75 shadow">
                    @else
                        <img src="{{asset('image/default-female-image.webp')}}" class=" w-75 shadow">
                    @endif
                    @else
                        <img src="{{asset('storage/'.Auth::user()->image)}}" class=" w-75 shadow">
                    @endif
                </div>
                <div class="col-lg-8">
                    <div class="mt-4"><h1>{{Auth::user()->name}}</h1></div>
                    <div class="my-1"><h4>{{Auth::user()->email}}</h4></div>
                    <div class="my-1 row">
                        <div class="col-lg-6">
                            <h5>12M+ Follower</h5>
                        </div>
                        <div class="col-lg-6">
                            <a href="{{route('admin#addPostPage')}}" class="btn btn-info"><i class="fa-solid fa-plus me-2"></i>Add Post</a>
                            <a href="{{route('admin#profileEdit')}}" class="btn btn-light"><i class="fa-solid fa-pen-to-square"></i>Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                @foreach ($posts as $post)
                <div class="shadow my-2 p-5">
                    <div class="row">

                    @if ($post->image!=null)
                        <div class="col-lg-3">
                            <img src="{{asset('storage/'.$post->image)}}" class="card-img" class="w-100">
                        </div>
                    @else
                        <div class="col-lg-3">
                            <img src="{{asset('image/default.png')}}" class="card-img" class="w-100">
                        </div>
                    @endif

                        <div class="col-lg-9">

                            <h4 class=""><a href="{{route('admin#viewPost',$post->id)}}">{{$post->Title}}</a></h4>

                            <h5 class="text-muted">by <a href="{{route('admin#viewProfile',$post->user_id)}}">{{$post->user_name}}</a></h5>
                            <p class="text-muted">{{$post->created_at->format('d-m-Y')}}</p>

                            @if ($post->playlist_id!=null)
                                <p><a href="{{route('admin#playlistItem',$post->playlist_id)}}">({{$post->playlist_name}})</a></p>
                            @endif

                            <p class="">{!! Str::limit($post->content, 100) !!}</p>

                            <div class="row">
                                <div class="col-6">
                                    <div class="btn btn-light"><a href="{{route('admin#postList',['category_id'=>$post->category_id])}}">{{$post->category_name}}</a></div>
                                    <span><i class="fa-solid fa-eye me-2"></i>{{$post->view_count}}</span>
                                </div>
                                <div class="col-4 offset-2">
                                    <a href="{{route('admin#deletePost',$post->id)}}" class="btn btn-danger me-2" title="Delete"><i class="fa-solid fa-trash me-2"></i>Delete</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-6">
                            <a href="{{route('admin#setLike',$post->id)}}" class="btn btn-light">
                                @if (!$post->my_like_status) <i class="fa-regular fa-heart me-2"></i> @else <i class="fa-solid fa-heart text-danger me-2"></i> @endif Like {{$post->like_count}}
                            </a>
                        </div>
                        <div class="col-6">
                            <div>
                                <a href="#" class="btn btn-light">
                                    <i class="fa-solid fa-message me-2"></i>Comment
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
