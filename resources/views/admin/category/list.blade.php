@extends('admin.main.main')

@section('title')
    Category List
@endsection

@section('contect')
    <div class="container py-5">
        <h1 class="text-center mb-5">Category List</h1>

        @if (session('createSucc'))
        <div class="alert alert-success alert-dismissible fade show col-lg-4 offset-lg-8" role="alert">
            {{session('createSucc')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('updateSucc'))
        <div class="alert alert-success alert-dismissible fade show col-lg-4 offset-lg-8" role="alert">
            {{session('updateSucc')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if (session('deleteSucc'))
        <div class="alert alert-danger alert-dismissible fade show col-lg-4 offset-lg-8" role="alert">
            {{session('deleteSucc')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div>
            <a href="{{route('admin#categoryAddpage')}}" class="btn btn-secondary float-lg-end"><i class="fa-solid fa-plus"></i>Add Category</a>
        </div>

        <div>
            <form action="#" method="get" class="row text-center">
            <div class="col-lg-4">Search Key - {{request('search_key')}}</div>
            <div class="col-lg-4">Total - {{$data->total()}}</div>
            <div class="col-lg-4">
                <div class="input-group mb-3">
                    <input type="text" name="search_key" class="form-control" value="{{request('search_key')}}" placeholder="Enter Author Name" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <input class="btn btn-secondary" type="submit" id="button-addon2" value="Search">
                </div>
            </div>
        </form>
        </div>
        <table class="table table-striped rounded">
            <thead>
                <tr class="text-center py-3">
                    <th>Id</th>
                    <th>Name</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                <tr class="text-center">
                    <td class="py-5"><h3>{{$item->id}}</h3></td>
                    <td class="py-5"><h3 class='text-center'>{{$item->name}}</h3></td>
                    <td class="py-5">
                        <a href="{{route('admin#categoryEdit',$item->id)}}" class="btn btn-light rounded-circle me-2" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a href="{{route('admin#categoryDelete',$item->id)}}" class="btn btn-light rounded-circle me-2" title="Delete"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            {{$data->appends(request()->query())->links()}}
        </div>
    </div>
@endsection
