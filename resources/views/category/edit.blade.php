@extends('layouts.back')
@section('title', 'Edit User')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Category</h4>
                    <a href="{{ route('category.index') }}" class="btn btn-primary btn-lg pull-right"><i class="bi bi-plus-circle"></i>Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="row form-material">
                            <div class="col-md-6">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <input type="text" class="form-control @error('category_name') is-invalid @enderror" id="category_name" name="category_name" value="{{ $category->category_name }}">
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('category_name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material mt-2">
                            <div class="col-md-6">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Category Image</label>
                                <input type="file" id="cat_image" name="cat_image" multiple {{(isset($category->cat_image) && $category->cat_image != '') ? '':'required'}}>
                                @if ($errors->has('cat_image'))
                                <span class="text-danger">{{ $errors->first('cat_image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material mt-2">
                            @if(isset($category->cat_image) && $category->cat_image != '')
                            <div class="col-md-6 img_0">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start">Previous Image</label>
                                <div class="image-container ">
                                    <center><img src="{{url(Storage::url($category->cat_image))}}" width="200px" height="200px" /></center>
                                    <input type="hidden" name="old_image" value="{{$category->cat_image}}">
                                </div><button class="btn btn-danger mt-2" type="button" id="delete_images" onclick="deleteImg('img_0')">Delete</button>
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
@push('scripts')
<script>
    function deleteImg(imgid) {
        if (confirm('Are you Sure ?')) {
            $('.img_' + imgid).remove();
        }
    }
</script>

@endpush