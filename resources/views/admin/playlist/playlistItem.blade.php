@extends('admin.main.main')

@section('title')
    Playlist Item
@endsection

@section('contect')
    <div class="container py-5">
        <h1 class="text-center my-2">{{$playList->name}}</h1>

        @if (session('removeSucc'))
        <div class="alert alert-danger alert-dismissible fade show col-4 offset-8" role="alert">
            {{session('removeSucc')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if ($playList->user_id==Auth::user()->id)
            <div>
                <a href="{{route('admin#addPlaylistItemPage',$playList->id)}}" class="btn btn-secondary float-lg-end"><i class="fa-solid fa-plus"></i>Add To Playlist</a>
            </div>
        @endif
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

                @foreach ($posts as $post)
                <div class="col-lg-8 offset-lg-2 shadow my-2 p-5">
                    <div class="row">

                    @if ($post->image!=null)
                        <div class="col-lg-3">
                                <img src="{{asset('storage/'.$post->image)}}" class="card-img" class="w-100">
                        </div>
                    @endif

                        <div class="@if ($post->image!=null) col-lg-9 @endif">

                            <div class="row">
                                <h4 class="col-6"><a href="{{route('admin#viewPost',$post->id)}}">{{$post->Title}}</a></h4>
                                @if ($playList->user_id==Auth::user()->id)
                                    <a title="remove" href="{{route('admin#removePlaylistItem',$post->id)}}" class="btn btn-light col-1 offset-4"><i class="fa-solid fa-xmark text-danger"></i></a>
                                @endif
                            </div>

                            <h5 class="text-muted">by {{$post->user_name}}</h5>
                            <p class="text-muted">{{$post->created_at->format('d-m-Y')}}</p>

                            @if ($post->playlist_id!=null) <p>({{$post->playlist_name}})</p> @endif

                            <p class="">{{ Str::limit($post->content, 100) }}</p>

                            <div class="btn btn-light">{{$post->category_name}}</div>
                            <span><i class="fa-solid fa-eye me-2"></i>{{$post->view_count}}</span>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        <div>
            {{$posts->appends(request()->query())->links()}}
        </div>
    </div>
@endsection
