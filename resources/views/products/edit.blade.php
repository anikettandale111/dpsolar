@extends('layouts.back')
<style>
    .image-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .image-box {
        width: 250px;
        height: 250px;
        margin: 10px;
        box-sizing: border-box;
        /* Include padding and border in element's total width and height */
    }

    .image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Cover the box while maintaining aspect ratio */
    }

    /* Responsive Design */
    @media (max-width: 800px) {
        .image-box {
            width: calc(50% - 20px);
            /* For 2 images per row with 10px margin */
        }
    }

    @media (max-width: 500px) {
        .image-box {
            width: calc(100% - 20px);
            /* For 1 image per row with 10px margin */
        }
    }
</style>
@section('title', 'Edit Prodcut')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Product Edit</h4>
                    <div class="card-header-form">
                        <a href="{{ route('products.index') }}" class="btn btn-primary my-2"><i class="bi bi-plus-circle"></i>Back</a>
                    </div>
                    <form action="{{ route('products.update', $product->pid) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Category Name</label>
                                <select class="form-control @error('name') is-invalid @enderror" id="cat_id" name="cat_id" required>
                                    @if ($errors->has('cat_id'))
                                    <span class="text-danger">{{ $errors->first('cat_id') }}</span>
                                    @endif
                                    <option disabled selected>Select Category</option>
                                    @if(count($category))
                                    @foreach($category AS $cat)
                                    <option value="{{$cat->id}}" {{($product->cat_id == $cat->id)?'selected':''}}>{{$cat->category_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Sub-Category Name</label>
                                <select type="text" class="form-control @error('sub_cat_id') is-invalid @enderror" id="sub_cat_id" name="sub_cat_id" required>
                                    @if ($errors->has('sub_cat_id'))
                                    <span class="text-danger">{{ $errors->first('sub_cat_id') }}</span>
                                    @endif
                                    <option disabled selected>Select Sub-category</option>
                                    @if(count($subcategory))
                                    @foreach($subcategory AS $subcat)
                                    <option value="{{$subcat->sid}}" {{($product->sub_cat_id == $subcat->sid)?'selected':''}}>{{$subcat->sub_cat_name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Product Name</label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                                @if ($errors->has('product_name'))
                                <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Product Description</label>
                                <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" row="5" required>{{ $product->description }}
                                @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                                </textarea>
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Product Features</label>
                                <textarea type="text" class="form-control @error('features') is-invalid @enderror" id="features" name="features" row="5" required>{{ $product->features }}
                                @if ($errors->has('features'))
                                <span class="text-danger">{{ $errors->first('features') }}</span>
                                @endif
                                </textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Ratings</label>
                                <select type="text" class="form-control @error('user_rating') is-invalid @enderror" id="user_rating" name="user_rating" row="5" value="{{ $product->user_rating }}" required>
                                    @if ($errors->has('user_rating'))
                                    <span class="text-danger">{{ $errors->first('user_rating') }}</span>
                                    @endif
                                    <option selected disabled>Select Rating</option>
                                    <option value="1" {{ ($product->user_rating == 1)?'selected':'' }}>1</option>
                                    <option value="2" {{ ($product->user_rating == 2)?'selected':'' }}>2</option>
                                    <option value="3" {{ ($product->user_rating == 3)?'selected':'' }}>3</option>
                                    <option value="4" {{ ($product->user_rating == 4)?'selected':'' }}>4</option>
                                    <option value="5" {{ ($product->user_rating == 5)?'selected':'' }}>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Discount</label>
                                <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" row="5" value="{{ $product->discount }}" required>
                                @if ($errors->has('discount'))
                                <span class="text-danger">{{ $errors->first('discount') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Display Price</label>
                                <input type="text" class="form-control @error('display_price') is-invalid @enderror" id="display_price" name="display_price" row="5" value="{{ $product->display_price }}" required>
                                @if ($errors->has('display_price'))
                                <span class="text-danger">{{ $errors->first('display_price') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Selling Price</label>
                                <input type="text" class="form-control @error('selling_price') is-invalid @enderror" id="selling_price" name="selling_price" row="5" value="{{ $product->selling_price }}" required>
                                @if ($errors->has('selling_price'))
                                <span class="text-danger">{{ $errors->first('selling_price') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Available Stock </label>
                                <input type="text" class="form-control @error('avbl_stock') is-invalid @enderror" id="avbl_stock" name="avbl_stock" row="5" value="{{ $product->avbl_stock }}" required>
                                @if ($errors->has('avbl_stock'))
                                <span class="text-danger">{{ $errors->first('avbl_stock') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Weight </label>
                                <input type="text" class="form-control @error('Weight') is-invalid @enderror" id="weight" name="weight" value="{{ $product->weight }}" required>
                                @if ($errors->has('weight'))
                                <span class="text-danger">{{ $errors->first('weight') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">height </label>
                                <input type="text" class="form-control @error('height') is-invalid @enderror" id="height" name="height" row="5" value="{{ $product->height }}" required>
                                @if ($errors->has('height'))
                                <span class="text-danger">{{ $errors->first('height') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Color </label>
                                <input type="text" class="form-control @error('color') is-invalid @enderror" id="color" name="color" row="5" value="{{ $product->color }}" required>
                                @if ($errors->has('color'))
                                <span class="text-danger">{{ $errors->first('color') }}</span>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Size </label>
                                <input type="text" class="form-control @error('size') is-invalid @enderror" id="size" name="size" row="5" value="{{ $product->size }}" required>
                                @if ($errors->has('size'))
                                <span class="text-danger">{{ $errors->first('size') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Product Images</label>
                                <input type="file" id="images" name="images[]" multiple>
                                @if ($errors->has('images'))
                                <span class="text-danger">{{ $errors->first('images') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            @if(isset($product->images) && count(json_decode($product->images)))
                            @php
                            $imgsarray = json_decode($product->images);
                            foreach($imgsarray AS $key => $imgs){
                            echo '<div class="col-md-3 img_'.$key.'">
                                <div class="image-container ">
                                    <center><img src="'.url(Storage::url($imgs)).'" width="200px" height="200px" /></center>
                                    <input type="hidden" name="old_images[]" value="'.$imgs.'">
                                </div><button class="btn btn-danger mt-2" type="button" id="delete_images" onclick="deleteImg('.$key.')">Delete</button></center>
                            </div>';
                            }
                            @endphp
                            @endif

                        </div>

                        <div class="row form-material">
                            <div class="col-md-6">
                                <label for="name" class="m-t-20">Is Active</label>
                                <input type="checkbox" id="is_active" name="is_active" row="5" value="{{ $product->is_active }}" required {{($product->is_active == 1) ? 'checked':''}}>
                                @if ($errors->has('is_active'))
                                <span class="text-danger">{{ $errors->first('is_active') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row form-material">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Product">
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
    $(document).ready(function() {
        $('#cat_id').change(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '{{config("app.url")}}' + 'getsubcat/' + categoryId,
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

    function deleteImg(imgid) {
        if (confirm('Are you Sure ?')) {
            $('.img_' + imgid).remove();
        }
    }
</script>

@endpush