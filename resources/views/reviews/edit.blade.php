@extends('layouts.back')
@section('title', 'Edit Review')
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Manage Reviews</h4>
                    <a href="{{ route('reviews.index') }}" class="btn btn-primary btn-lg pull-right">&larr; Back</a>
                </div>
                <div class="card-body">
                        <form action="{{ route('reviews.update', $reviews->id) }}" method="post">
                            @csrf
                            @method("PUT")
                            <input type="hidden" name="user_id" id="user_id" value="{{Auth::user()->id}}">
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">User Name</label>
                                    <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ $reviews->user_name }}">
                                    @if ($errors->has('user_name'))
                                    <span class="text-danger">{{ $errors->first('user_name') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Select Product</label>
                                    <select type="text" class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id" value="{{ old('product_id') }}">
                                    <option selected disabled>Select Product</option>
                                    @foreach($product AS $key => $prod)
                                        <option value="{{$prod->pid}}" {{($prod->pid == $reviews->product_id) ? 'selected' : ''}}>{{$prod->product_name}}</option>
                                    @endforeach
                                    </select>
                                    @if ($errors->has('product_id'))
                                    <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-material">
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Rating</label>
                                    <select class="form-control @error('rating') is-invalid @enderror" id="rating" name="rating" row="5" value="{{ old('rating') }}">
                                    <option selected disabled>Select Rating</option>
                                        <option value="1" {{($reviews->rating == 1) ? 'selected' : ''}}>1</option>
                                        <option value="2" {{($reviews->rating == 2) ? 'selected' : ''}}>2</option>
                                        <option value="3" {{($reviews->rating == 3) ? 'selected' : ''}}>3</option>
                                        <option value="4" {{($reviews->rating == 4) ? 'selected' : ''}}>4</option>
                                        <option value="5" {{($reviews->rating == 5) ? 'selected' : ''}}>5</option>
                                    </select>
                                    @if ($errors->has('rating'))
                                        <span class="text-danger">{{ $errors->first('rating') }}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                                    <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" row="5" >{{ $reviews->description}}</textarea>
                                    @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row form-material mt-3">
                                <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Update Reviews">
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
function deleteImg(imgid){
        if(confirm('Are you Sure ?')){
            $('.img_'+imgid).remove();
        }
    }
</script>

@endpush