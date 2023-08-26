@extends('admin.main.main')
@section('title')
View Message
@endsection
@section('contect')
<div class="container py-5">
    <h1 class=" text-center">View Email</h1>
    <div class="my-2">
        <div class=" shadow rounded p-2">
            <h3 class="text-center py-2">{{$message->title}}</h3>
            <div class="row">
                <div class="px-5 py-1 col-lg-3">
                    <p>From - {{$message->sent_email}}</p>
                    <p>To - {{$message->receive_email}}</p>
                </div>
                <div class="px-5 py-1 col-lg-9">
                    <p>{{$message->content}}</p>
                </div>
            </div>
            @if ($message->receive_email==Auth::user()->email)
                <div class="d-flex justify-content-end">
                    <a href="{{route('admin#sendMessagePage',$message->id)}}" class="btn btn-secondary"><i class="fa-solid fa-reply me-2"></i>Reply</a>
                </div>
            @endif

        </div>
    </div>

    @if (count($reply_message) != 0)
        <div>
            <div class="container shadow p-2">
                @foreach ($reply_message as $item)
                    <div class="border border-secondary p-3">
                        <h3 class="text-center py-2">{{$item->title}}</h3>
                        <div class="row">
                            <div class="px-5 py-1 col-lg-3">
                                <p>From - {{$item->sent_email}}</p>
                                <p>To - {{$item->receive_email}}</p>
                            </div>
                            <div class="px-5 py-1 col-lg-9">
                                <p>{{$item->content}}</p>
                            </div>
                        </div>
                        @if ($item->receive_email==Auth::user()->email)
                            <div class="d-flex justify-content-end">
                                <a href="{{route('admin#sendMessagePage',$message->id)}}" class="btn btn-secondary"><i class="fa-solid fa-reply me-2"></i>Reply</a>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
