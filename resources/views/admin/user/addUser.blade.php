@extends('admin.main.main')

@section('title')
    Add User
@endsection

@section('contect')
    <div class="container py-5">
        <h1 class=" text-center">Add User</h1>
        <form action="{{route('admin#addUser')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="shadow p-5 row">
                <div class="col-lg-4">
                    <img src="{{asset('image/default-male-image.png')}}" class="w-75 shadow">
                    <input name="image" type="file" class="form-control my-4 @error('image') is-invalid @enderror">
                    @error('image')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-lg-8">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Email">
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
                            <option value="male">Male</option>
                            <option value="female">Female</option>
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
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                        <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="inputPassword" placeholder="Enter Password">
                        @error('password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                        <input name="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="inputPassword" placeholder="Enter Confirm Password">
                        @error('confirm_password')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-plus me-2"></i>Create</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
