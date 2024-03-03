@extends('admin.main.main')
@section('title')
Message List
@endsection
@section('contect')
<div class="container py-5">
    <h1 class="text-center mb-5">Message List</h1>

    @if (session('createSucc'))
    <div class="alert alert-success alert-dismissible fade show col-lg-4 offset-lg-8" role="alert">
        {{session('createSucc')}}
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
        <a href="{{route('admin#sendMessagePage',0)}}" class="btn btn-secondary float-lg-end"><i class="fa-solid fa-plus"></i>Sent Message</a>
    </div>

    <div>
        <form action="{{route('admin#userList')}}" method="get" class="row text-center">
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
    <div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle text-capitalize" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{$status}} Email
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{route('admin#messageList','receive')}}">Receive Email</a></li>
                <li><a class="dropdown-item" href="{{route('admin#messageList','sent')}}">Sent Email</a></li>
            </ul>
        </div>
    </div>
    <table class="table rounded">
        <thead>
            <tr class="text-center py-3">
                <th>Id</th>
                <th>Title</th>
                <th>Sent Email</th>
                <th class="d-none d-lg-table-cell">Receive Email</th>
                <th class="d-none d-lg-table-cell">Message</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr class="text-center @if ($item->status==0) bg-secondary text-white @endif">
                <td class="py-5">@if ($item->reply_id!=0) <i class="fa-solid fa-reply me-2"></i> @endif{{$item->id}}</td>
                <td class="py-5">{{$item->title}}</td>
                <td class="py-5">{{$item->sent_email}}</td>
                <td class="py-5 d-none d-lg-table-cell">{{$item->receive_email}}</td>
                <td class="py-5 d-none d-lg-table-cell">{{Str::limit($item->content, 50)}}</td>
                <td class="py-5">
                    <a href="{{route('admin#viewMessage',$item->id)}}" class="btn btn-light rounded-circle me-2" title="View"><i class="fa-solid fa-eye"></i></a>
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
