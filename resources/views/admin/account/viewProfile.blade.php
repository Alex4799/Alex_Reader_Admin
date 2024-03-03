@extends('admin.main.main')

@section('title')
   View Profile
@endsection

@section('contect')

    <div class="container py-5">
        <h1 class="text-center">View Profile</h1>
        <div class="p-3 shadow">
            <div class="row">
                <div class="col-lg-3">
                    @if ($data->image==null)
                    @if ($data->gender=='male')
                        <img src="{{asset('image/default-male-image.png')}}" class=" w-75 shadow">
                    @else
                        <img src="{{asset('image/default-female-image.webp')}}" class=" w-75 shadow">
                    @endif
                    @else
                        <img src="{{asset('storage/'.$data->image)}}" class=" w-75 shadow">
                    @endif
                </div>
                <div class="col-lg-8">
                    <div class="mt-4"><h1><i class="fa-solid fa-user me-2"></i>{{$data->name}}</h1></div>
                    <div class="my-1"><h4><i class="fa-solid fa-envelope me-2"></i>{{$data->email}}</h4></div>
                    <div class="my-1 row">
                        <div class="col-lg-6">
                            <h5 class="btn btn-outline-dark"><i class="fa-solid fa-pen-nib me-2"></i>{{$data->role}}</h5>
                            <h5 class="btn btn-outline-dark"><i class="fa-solid fa-venus-mars me-2"></i>{{$data->gender}}</h5>
                        </div>

                        @if ($data->role=='user')
                            <div class="col-lg-6">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle text-capitalize" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{$data->role}}
                                    </button>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{route('admin#changeRole',[$data->id,1])}}">Admin</a></li>
                                    <li><a class="dropdown-item" href="#">User</a></li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                        @if ($data->role=='admin'&& Auth::user()->id==1)
                        <div class="col-lg-6">
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle text-capitalize" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{$data->role}}
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Admin</a></li>
                                    <li><a class="dropdown-item" href="{{route('admin#changeRole',[$data->id,2])}}">User</a></li>
                                </ul>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>

        <div>
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
                            </div>
                            <div class="row my-2">
                                <div class="col-6">
                                    <a href="{{route('admin#setLike',$post->id)}}" class="btn btn-light">
                                        @if (!$post->my_like_status) <i class="fa-regular fa-heart me-2"></i> @else <i class="fa-solid fa-heart text-danger me-2"></i> @endif Like {{$post->like_count}}
                                    </a>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <a href="{{route('admin#viewPost',$post->id)}}" class="btn btn-light">
                                            <i class="fa-solid fa-message me-2"></i>Comment
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
