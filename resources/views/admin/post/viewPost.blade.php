@extends('admin.main.main')

@section('title')
   View Post
@endsection

@section('contect')
    <div class=" container-fluid py-5">
        <h1 class="text-center">View Post</h1>

        @if (session('updatePostSucc'))
        <div class="alert alert-success alert-dismissible fade show col-4 offset-8" role="alert">
            {{session('updatePostSucc')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

            <div class="row">

                @if ($post->playlist_id!=null)
                    <div class="col-lg-2">
                        <h1 class=" text-center">{{$post->playlist_name}}</h1>
                        @foreach ($playListItem as $item)
                            <a href="{{route('admin#viewPost',$item->id)}}" class="btn btn-outline-dark w-100">{{$item->Title}}</a>
                        @endforeach
                    </div>
                @endif

                <div class="col-lg-8 @if ($post->playlist_id==null) offset-lg-2 @endif shadow my-2 p-5">
                    <div class="row my-2">
                    @if ($post->image!=null)
                        <div class="col-3">
                                <img src="{{asset('storage/'.$post->image)}}" class="card-img" class="w-100">
                        </div>
                    @else
                        <div class="col-3">
                            <img src="{{asset('image/default.png')}}" class="card-img" class="w-100">
                        </div>
                    @endif
                        <div class="col-9">
                            <h4 class="">{{$post->Title}}</h4>

                            <h5 class="text-muted">by <a href="{{route('admin#viewProfile',$post->user_id)}}">{{$post->user_name}}</a></h5>
                            <p class="text-muted">{{$post->created_at->format('d-m-Y')}}</p>

                        @if ($post->playlist_id!=null)
                            <p><a href="{{route('admin#playlistItem',$post->playlist_id)}}">({{$post->playlist_name}})</a></p>
                        @endif

                                <div class="btn btn-light"><a href="{{route('admin#postList',['category_id'=>$post->category_id])}}">{{$post->category_name}}</a></div>
                            <span><i class="fa-solid fa-eye me-2"></i>{{$post->view_count}}</span>
                        </div>
                    </div>
                    <p class="">{!! $post->content !!}</p>

                    <div class="row">

                        <div class="col-6">
                            <div class="my-2">
                                <a href="{{route('admin#setLike',$post->id)}}" class="btn btn-light">
                                    @if (!$post->my_like_status) <i class="fa-regular fa-heart me-2"></i> @else <i class="fa-solid fa-heart text-danger me-2"></i> @endif Like {{$post->like_count}}
                                </a>
                            </div>
                        </div>

                        <div class="col-6">
                            @if ($post->user_id==Auth::user()->id)
                                <div class="float-end">
                                    <a href="{{route('admin#editPost',$post->id)}}" class="btn btn-light shadow"><i class="fa-solid fa-pen-to-square me-2"></i>Edit</a>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>

                <div class="col-lg-2">
                    <h1 class="text-center">Related Post</h1>
                    @foreach ($relatedPost as $item)
                    <div class="row my-2 shadow p-2">

                        @if ($item->image!=null)
                            <div class="col-3">
                                    <img src="{{asset('storage/'.$item->image)}}" class="card-img" class="w-100">
                            </div>
                        @else
                            <div class="col-3">
                                <img src="{{asset('image/default.png')}}" class="card-img" class="w-100">
                            </div>
                        @endif

                            <div class="col-9">

                                <h5 class=""><a class="text-dark text-decoration-none" href="{{route('admin#viewPost',$item->id)}}">{{$item->Title}}</a></h5>

                                <p class="text-muted">by {{$item->user_name}}</p>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
            <div class="row">
                <div class="offset-lg-2 col-lg-8">
                    <h1>Comment</h1>

                    <form action="{{route('admin#sendComment')}}" method="post">
                        @csrf
                        <div class="row shadow p-3 my-3">
                            <div class="col-6 offset-2">
                                <textarea name="comment" class="form-control @error('comment') is-invalid @enderror" cols="30" rows="1" placeholder="Enter your comment"></textarea>
                                @error('comment')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror

                                <input type="hidden" name='user_id' value="{{Auth::user()->id}}">
                                <input type="hidden" name='post_id' value="{{$post->id}}">
                            </div>
                            <div class="col-2">
                                <button class="btn btn-light ">Send</button>
                            </div>
                        </div>
                    </form>

                    @foreach ($comments as $comment)

                    @if ($comment->reply_id==null)
                        <div class="p-3 border rounded my-2 comment">
                            <h5><a href="{{route('admin#viewProfile',$comment->user_id)}}">{{$comment->user_name}}</a></h5>
                            <p class="px-2">{{$comment->comment}}</p>
                            <div class="row">
                                <a class="btn btn-light col-2 offset-8 reply">
                                    <i class="fa-solid fa-reply"></i>Reply
                                </a>
                                <a class="btn btn-light col-2 offset-8 close" style="display: none">
                                    <i class="fa-solid fa-xmark"></i>Close
                                </a>
                            </div>

                            <div id='reply-box' style="display: none">
                                <form action="{{route('admin#sendComment')}}" method="post">
                                    @csrf
                                    <div class="row my-3">
                                        <div class="col-6 offset-2">
                                            <textarea name="comment" class="form-control" cols="30" rows="1" placeholder="Enter your comment"></textarea>
                                            <input type="hidden" name='user_id' value="{{Auth::user()->id}}">
                                            <input type="hidden" name='post_id' value="{{$post->id}}">
                                            <input type="hidden" name="reply_id" value="{{$comment->id}}">
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-light shadow">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            @foreach ($comments as $item)
                                @if ($comment->id == $item->reply_id)
                                    <div class="p-3 border rounded mt-2">
                                        <h5><a href="{{route('admin#viewProfile',$item->user_id)}}">{{$item->user_name}}</a></h5>
                                        <p class="px-2">{{$item->comment}}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @endforeach
                </div>
            </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.reply').click(function(){
                $parents=$(this).parents('.comment');
                $parents.find('#reply-box').show();
                $parents.find('.close').show();
                $parents.find('.reply').hide();
            });
            $('.close').click(function(){
                $parents=$(this).parents('.comment');
                $parents.find('#reply-box').hide();
                $parents.find('.close').hide();
                $parents.find('.reply').show();
            });
        });
    </script>
@endsection
