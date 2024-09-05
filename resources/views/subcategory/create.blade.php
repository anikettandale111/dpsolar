@extends('layouts.back')
@section('title', 'Add New User')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create Sub-Category</h4>
                    <a href="{{ route('subcategory.index') }}" class="btn btn-primary btn-lg pull-right">&larr; Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('subcategory.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Category Name</label>
                                <select class="form-control @error('name') is-invalid @enderror" id="cat_id" name="cat_id">
                                    @if ($errors->has('cat_id'))
                                    <span class="text-danger">{{ $errors->first('cat_id') }}</span>
                                    @endif
                                    <option disabled selected>Select Category</option>
                                    @if(count($category))
                                    @foreach($category AS $cat)
                                    <option value="{{$cat->id}}">{{$cat->category_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Sub-Category Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="sub_cat_name" name="sub_cat_name" value="{{ old('sub_cat_name') }}">
                                @if ($errors->has('sub_cat_name'))
                                <span class="text-danger">{{ $errors->first('sub_cat_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Subcategory Image</label>
                                <input type="file" id="sub_cat_image" name="sub_cat_image" multiple required>
                                @if ($errors->has('sub_cat_image'))
                                <span class="text-danger">{{ $errors->first('sub_cat_image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add SUb-Category">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection