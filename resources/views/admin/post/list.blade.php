@extends('admin.main.main')

@section('title')
    Post
@endsection

@section('contect')
    <div class="container py-5">
        <div>
            <a href="{{route('admin#addPostPage')}}" class="btn btn-secondary float-lg-end"><i class="fa-solid fa-plus"></i>Add Post</a>
        </div>
        <div>
            <form action="#" method="get" class="row text-center">
                <div class="col-lg-4">Search Key - {{request('search_key')}}</div>
                <div class="col-lg-4">Total - {{$posts->total()}}</div>
                <div class="col-lg-4">
                    <div class="input-group mb-3">
                        <input type="text" name="search_key" class="form-control" value="{{request('search_key')}}" placeholder="Enter Author Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <input class="btn btn-secondary" type="submit" id="button-addon2" value="Search">
                    </div>
                </div>
            </form>
        </div>
            <div class="row">
                <div class="col-lg-2">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><a href="{{route('admin#postList')}}">All</a></td>
                            </tr>
                            <tr>
                                <td><a href="{{route('admin#postList',['trendPost'=>true])}}">Trend Post</a></td>
                            </tr>
                            @foreach ($categories as $item)
                                <tr>
                                    <td><a href="{{route('admin#postList',['category_id'=>$item->id])}}">{{$item->name}}</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
                <div class="col-lg-8">
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
                                    @if ($post->user_id==Auth::user()->id)
                                        <div class="col-4 offset-2">
                                            <a href="{{route('admin#deletePost',$post->id)}}" class="btn btn-danger me-2" title="Delete"><i class="fa-solid fa-trash me-2"></i>Delete</a>
                                        </div>
                                    @endif
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
        <div>
            {{$posts->appends(request()->query())->links()}}
        </div>
    </div>
@endsection
