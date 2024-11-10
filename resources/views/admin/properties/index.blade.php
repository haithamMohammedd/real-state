@extends('admin.master')

@section('title','All Properties | ' . env('APP_NAME'))

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-4 text-gray-800">All properties</h1>
        <a href="{{ route('admin.properties.create') }}" class="btn btn-success px-5">Add New</a>
    </div>

    @if (session('msg'))
       <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
       </div>
    @endif

    <table class="table table-bordered table-hover table-striped">
        <tr class="bg-dark text-white text-center">
            <th>ID</th>
            <th>Prperty Type</th>
            <th>Price</th>
            <th>Address</th>
            <th>Image</th>
            <th>Listing Status</th>
            <th>Date Listed</th>
            <th>Actions</th>
        </tr>

        @foreach ($properties as $property)
            <tr class="text-center ">
                <td>{{ $property->id }}</td>
                <td>{{ $property->property_type }}</td>
                <td>{{ $property->price }}</td>
                <td>{{ $property->address }}</td>
                <td>
                    @if(!empty($property->main_image))
                        <img src="{{ asset('uploads/' . $property->main_image) }}" alt="Property Image" width="80">
                    @else
                        <span>Not Found Image</span>
                    @endif
                </td>
                <td>{{ $property->listing_status }}</td>
                <td>{{ $property->date_listed }}</td>
                <td>
                    <a  href="{{ route('admin.properties.edit',$property->id) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form class="d-inline" action="{{ route('admin.properties.destroy',$property->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button onclick="confirm('Are you sure?')" class="btn btn-sm btn-danger">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $properties->links() }}
@stop

