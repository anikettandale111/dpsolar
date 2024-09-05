@extends('layouts.back')
@section('title', 'Edit Sub-Category')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Sub-Category</h4>
                    <a href="{{ route('subcategory.index') }}" class="btn btn-primary btn-lg pull-right"><i class="bi bi-plus-circle"></i>Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('subcategory.update', $subcategory->sid) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
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
                                    <option value="{{$cat->id}}" {{($cat->id==$subcategory->cat_id)?'selected':''}}>{{$cat->category_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <input type="text" class="form-control @error('sub_cat_name') is-invalid @enderror" id="sub_cat_name" name="sub_cat_name" value="{{ $subcategory->sub_cat_name }}">
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('sub_cat_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Subcategory Image</label>
                                <input type="file" id="sub_cat_image" name="sub_cat_image" multiple {{(isset($subcategory->sub_cat_image) && $subcategory->sub_cat_image != '') ? '':'required'}}>
                                @if ($errors->has('sub_cat_image'))
                                <span class="text-danger">{{ $errors->first('sub_cat_image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            @if(isset($subcategory->sub_cat_image) && $subcategory->sub_cat_image != '')
                            <div class="col-md-3 img_0">
                                <div class="image-container ">
                                    <center><img src="{{url(Storage::url($subcategory->sub_cat_image))}}" width="200px" height="200px" />
                                        <input type="hidden" name="old_image" value="{{$subcategory->sub_cat_image}}">
                                </div><button class="btn btn-danger mt-2" type="button" id="delete_images" onclick="deleteImg('img_0')">Delete</button></center>
                            </div>
                            @endif
                        </div>
                        <div class="row form-material">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Category">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection