@extends('layouts.app')
@section('content')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header "><h2 align="center">Images</h2></div>
                    <div class="card-body">
                        <a href="{{ url('/create') }}" class="btn btn-success btn-sm" title="Add New Contact">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Tag</th>
                                    <th>Photo</th>
                                </thead>
                                <tbody>
                                @isset($images)
                                    @foreach($images as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->category }}</td>
                                            <td>{{ json_encode($item->tag) }}</td>
    {{--                                        <td>{{ $item->thumbnail }}</td>--}}
                                            <td>
                                                <img src="{{ asset($item->image) }}" width= '50' height='50' class="img img-responsive" />
                                            </td>
                                        </tr>
                                    @endforeach
                                @endisset
                                </tbody>
                            </table>
                                @empty($images)
                                    <p align="center">don't have any records!</p>
                                @endempty
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
