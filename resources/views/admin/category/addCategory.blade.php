@extends('admin.main.main')

@section('title')
    Add Category
@endsection

@section('contect')
    <div class="container py-5">
        <h1 class="text-center mb-5">Add Category</h1>
            <form action="{{route('admin#categoryAdd')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-6 offset-lg-3 shadow p-5">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Name">
                            @error('name')
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
