@extends('admin.master')

@section('title','Edit Categories | ' . env('APP_NAME'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-4 text-gray-800">Edit Categories</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-success px-5">All Categories</a>
    </div>
    @include('admin.errors')
    <form action="{{ route('admin.categories.update',$category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
         <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $category->name }}">
         </div>

         <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image"class="form-control">
            <img width="80" src="{{ asset('uploads/'.$category->image) }}" alt="">
         </div>

         <button class="btn btn-success px-5"> <i class="fas fa-check"></i> Edit</button>
    </form>
@stop

