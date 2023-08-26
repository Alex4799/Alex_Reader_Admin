<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>
<body>
    <div class="py-5 row container-fluid">
        <div class="p-5 container shadow col-lg-6 offset-lg-3">
            <div class="row">
                <div class="col-lg-3 offset-lg-3">
                    <img class="w-100 rounded-circle" src="{{asset('image/lucifer.jpg')}}" alt="">
                </div>
                <div class="col-lg-5">
                    <div class="pt-3 text-center">
                        <h1 class="font-monospace">Alex</h1>
                        <h6 class="font-monospace">M e d i a  C o m p a n y</h6>
                    </div>
                </div>
            </div>
            <h3 class="text-center py-3">Login to Our Website</h3>

            <div id="error" class="py-2"></div>

            <form action="{{route('login')}}" method="post" id="form">
                @csrf
                <div class="py-2">
                    <label for="">Email</label>
                    <input type="text" class="form-control my-2" name="email" id="email" placeholder="Enter your email .....">
                    @error('email')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="py-2">
                    <label for="">Password</label>
                    <input type="password" class="form-control my-2" name="password" id="password" placeholder="Enter your password .....">
                    @error('password')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="py-2">
                    <a href="{{route('auth#registerPage')}}">You Don't have an account?</a>
                </div>
                <div class="py-2">
                    <div class="d-flex justify-content-end" id="loginBtnContainer">
                        <input type="button" id="loginBtn" value="Login" class="btn btn-primary justify-start">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('#loginBtn').click(function(){
                $email=$('#email').val();
                $password=$('#password').val();
                    if($email==''){
                        $('#loginBtnContainer').toggleClass('justify-content-end');
                        $('#error').html('<h6 class="text-danger">Email field is required !!!!</h6>');
                    }else if($password==''){
                        $('#loginBtnContainer').toggleClass('justify-content-end');
                        $('#error').html('<h6 class="text-danger">Password field is required !!!!</h6>');
                    }else{
                        $('#form').submit();
                    }

            })

        })
    </script>
</body>
</html>
