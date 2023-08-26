@extends('admin.main.main')

@section('contect')
<div class="py-5">
    <h1 class="text-danger text-center">You Don't Have Permission For This Page. Please Logout !!!!!!</h1>
    <div class=" d-flex justify-content-center">
        <form action="{{route('logout')}}" method="post">
            @csrf
            <input type="submit" value="Logout" class="btn btn-danger">
        </form>
    </div>
    <div>
        <h3 class=" text-center"><a target="_blank" href="http://alexmedia.user.alexlucifer.info" class="">Go to user page</a></h3>
    </div>
</div>
@endsection
