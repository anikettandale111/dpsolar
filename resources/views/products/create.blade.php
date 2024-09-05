@extends('layouts.back')
@section('title', 'Add Product')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Manage Product</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Product</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Product</h4>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm pull-right">&larr; Back</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Category Name</label>
                                    <select class="form-control @error('name') is-invalid @enderror" id="cat_id" name="cat_id" required>
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
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Sub-Category Name</label>
                                    <select type="text" class="form-control @error('sub_cat_id') is-invalid @enderror" id="sub_cat_id" name="sub_cat_id" required>
                                    @if ($errors->has('sub_cat_id'))
                                    <span class="text-danger">{{ $errors->first('sub_cat_id') }}</span>
                                    @endif
                                    <option disabled selected>Select Sub-category</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Product Name</label>
                                    <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ old('product_name') }}" required>
                                    @if ($errors->has('product_name'))
                                    <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Product Description</label>
                                    <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" row="5" value="{{ old('description') }}" required>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                    </textarea>
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Product Features</label>
                                    <textarea type="text" class="form-control @error('features') is-invalid @enderror" id="features" name="features" row="5" value="{{ old('features') }}" required>
                                    @if ($errors->has('features'))
                                    <span class="text-danger">{{ $errors->first('features') }}</span>
                                    @endif
                                    </textarea>
                                </div>
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Ratings</label>
                                    <select type="text" class="form-control @error('user_rating') is-invalid @enderror" id="user_rating" name="user_rating" row="5" value="{{ old('user_rating') }}" required>
                                    @if ($errors->has('user_rating'))
                                    <span class="text-danger">{{ $errors->first('user_rating') }}</span>
                                    @endif
                                        <option selected disabled>Select Rating</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Discount</label>
                                    <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" row="5" value="{{ old('discount') }}" required>
                                    @if ($errors->has('discount'))
                                    <span class="text-danger">{{ $errors->first('discount') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">Display Price</label>
                                    <input type="text" class="form-control @error('display_price') is-invalid @enderror" id="display_price" name="display_price" row="5" value="{{ old('display_price') }}" required>
                                    @if ($errors->has('display_price'))
                                    <span class="text-danger">{{ $errors->first('display_price') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Selling Price</label>
                                    <input type="text" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" row="5" value="{{ old('selling_price') }}" required>
                                    @if ($errors->has('selling_price'))
                                    <span class="text-danger">{{ $errors->first('selling_price') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">Available Stock </label>
                                    <input type="text" class="form-control @error('avbl_stock') is-invalid @enderror" id="avbl_stock" name="avbl_stock" row="5" value="{{ old('avbl_stock') }}" required>
                                    @if ($errors->has('avbl_stock'))
                                    <span class="text-danger">{{ $errors->first('avbl_stock') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Weight </label>
                                    <input type="text" class="form-control @error('Weight') is-invalid @enderror" id="weight" name="weight" row="5" value="{{ old('weight') }}" required>
                                    @if ($errors->has('Weight'))
                                    <span class="text-danger">{{ $errors->first('Weight') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">height </label>
                                    <input type="text" class="form-control @error('height') is-invalid @enderror" id="height" name="height" row="5" value="{{ old('height') }}" required>
                                    @if ($errors->has('height'))
                                    <span class="text-danger">{{ $errors->first('height') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Color </label>
                                    <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" row="5" value="{{ old('color') }}" required>
                                    @if ($errors->has('color'))
                                    <span class="text-danger">{{ $errors->first('color') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">Size </label>
                                    <input type="text" class="form-control @error('size') is-invalid @enderror" id="size" name="size" row="5" value="{{ old('size') }}" required>
                                    @if ($errors->has('size'))
                                    <span class="text-danger">{{ $errors->first('size') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Product Images</label>
                                    <input type="file" id="images" name="images[]" multiple required>
                                    @if ($errors->has('images'))
                                    <span class="text-danger">{{ $errors->first('images') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="col-md-4 col-form-label text-md-end text-start">Is Active</label>
                                    <input type="checkbox" id="is_active" name="is_active" row="5" value="{{ old('is_active') }}" required>
                                    @if ($errors->has('is_active'))
                                    <span class="text-danger">{{ $errors->first('is_active') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-material">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Product">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#cat_id').change(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '{{config("app.url")}}'+'getsubcat/' + categoryId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#sub_cat_id').empty();
                        $('#sub_cat_id').append('<option value="">Select a subcategory</option>');
                        $.each(data, function(key, value) {
                            $('#sub_cat_id').append('<option value="' + value.sid + '">' + value.sub_cat_name + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_cat_id').empty();
                $('#sub_cat_id').append('<option value="">Select a subcategory</option>');
            }
        });
    });
</script>

@endpush