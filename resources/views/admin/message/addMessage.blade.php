@extends('admin.main.main')
@section('title')
Send Message
@endsection
@section('contect')
<div class="container py-5">
    <h1 class=" text-center">Send Email</h1>
    <form action="{{route('admin#sendMessage')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class=" row">
            <div class=" p-5 shadow col-lg-8 offset-lg-2">
                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">To</label>
                    <div class="col-sm-9">
                    <input name="receive_email" value="{{$email}}" type="email" class="form-control @error('receive_email') is-invalid @enderror" placeholder="Enter email .....">
                    @error('receive_email')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    </div>
                </div>

                <input type="hidden" name="sent_email" value="{{Auth::user()->email}}">
                <input type="hidden" name="reply_id" value="{{$reply_id}}">


                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Title</label>
                    <div class="col-sm-9">
                    <input name="title" type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Enter email's title">
                    @error('title')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label">Content</label>
                    <div class="col-sm-9">
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror"  id="" cols="30" rows="10"></textarea>
                    @error('content')
                        <span class="text-danger">{{$message}}</span>
                    @enderror
                    </div>
                </div>

                <input type="hidden" name="sent_email" value="{{Auth::user()->email}}">

                <div class="float-end">
                    <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-plus me-2"></i>Create</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
