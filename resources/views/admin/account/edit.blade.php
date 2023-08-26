@extends('admin.main.main')

@section('title')
    Edit Profile
@endsection

@section('contect')
    <div class="container py-5">
        <h1 class=" text-center">Edit Profile</h1>
        <form action="{{route('admin#profileUpdate')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="shadow p-5 row">
                <div class="col-4">

                    @if (Auth::user()->image==null)
                    @if (Auth::user()->gender=='male')
                        <img src="{{asset('image/default-male-image.png')}}" class=" w-75 shadow">
                    @else
                        <img src="{{asset('image/default-female-image.webp')}}" class=" w-75 shadow">
                    @endif
                    @else
                        <img src="{{asset('storage/'.Auth::user()->image)}}" class=" w-75 shadow">
                    @endif

                    <input name="image" type="file" class="form-control my-4 @error('image') is-invalid @enderror">
                    @error('image')
                    <span class="text-danger">{{$message}}</span>
                    @enderror

                </div>
                <div class="col-8">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                        <input name="name" type="text" value="{{$data->name}}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                        <input name="email" type="email" value="{{$data->email}}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email">
                        @error('email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Gender</label>
                        <div class="col-sm-9">
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Choose Gender</option>
                            <option value="male" @if ($data->gender=='male') selected @endif>Male</option>
                            <option value="female" @if ($data->gender=='female') selected @endif>Female</option>
                        </select>
                        @error('gender')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select name="role" class="form-control">
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>

                    <div class="float-end">
                        <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-pen-to-square me-2"></i>Update</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection
