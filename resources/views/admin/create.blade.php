@extends('layouts.app')
    @section('content')
        <div class="card">
            <div class="card-header">Image Upload</div>
            <div class="card-body">
                <form action="{{ url('/') }}" method="post" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <label>Name</label></br>
                    <input type="text" name="name" id="name" class="form-control"></br>
                    <label>Category</label></br>
                    <input type="text" name="category" id="address" class="form-control"></br>
                    <label>Tag</label></br>
                    <input type="text" name="tag" id="tag" class="form-control"></br>
                    <input class="form-control" name="image" type="file" id="image"></br>

                    <input type="submit" value="Save" class="btn btn-success">
                </form>
            </div>
        </div>
    @stop
