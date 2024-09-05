@extends('layouts.back')
@section('title', 'Add New User')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Category</h4>
                    <a href="{{ route('category.index') }}" class="btn btn-primary btn-sm pull-right">&larr; Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="category_name" name="category_name" value="{{ old('category_name') }}">
                                @if ($errors->has('category_name'))
                                <span class="text-danger">{{ $errors->first('category_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material mt-2">
                            <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Category Image</label>
                                <input type="file" id="cat_image" name="cat_image" multiple required>
                                @if ($errors->has('cat_image'))
                                <span class="text-danger">{{ $errors->first('cat_image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material mt-2">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Category">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection