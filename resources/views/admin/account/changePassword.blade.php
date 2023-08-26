@extends('admin.main.main')
@section('title')
    Change Password
@endsection
@section('contect')
<div class="container py-5">
    <h1 class="text-center mb-5">Change password</h1>

        <form action="{{route('admin#changePassword')}}" method="post">
            @csrf
            <div class="row">
                @if (session('incorrect'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{session('incorrect')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="col-lg-6 offset-lg-3 shadow p-5">
                    <div class="mb-3">
                        <label class="">Current Password</label>
                        <div class="">
                        <input name="current_password" type="password" class="password form-control @error('name') is-invalid @enderror" placeholder="Enter Current Password">
                        @error('name')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="">New Password</label>
                        <div class="">
                        <input name="password" type="password" class="password form-control @error('name') is-invalid @enderror" placeholder="Enter New Password">
                        @error('password')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="">Confirm Password</label>
                        <div class="">
                        <input name="confirm_password" type="password" class="password form-control @error('name') is-invalid @enderror" placeholder="Enter Confirm Password">
                        @error('confirm_password')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <input type="checkbox" onclick="showPassword()" class="me-1">Show Password
                        </div>
                        <div class="col-lg-3 offset-lg-3">
                            <button class="btn btn-secondary" type="submit"><i class="fa-solid fa-plus me-2"></i>Create</button>
                        </div>
                    </div>

                </div>
            </div>
        </form>

</div>
@endsection
@section('script')
    <script>
        function showPassword(){
            let input=document.getElementsByClassName('password');
            for (let i = 0; i < input.length; i++) {
                if (input[i].type=='password') {
                    input[i].type='text';
                }else{
                    input[i].type='password'
                }
            }
        }
    </script>
@endsection
