@extends('frontend.front')
@section('title', 'Product Information')
@push('styles')
@endpush
@section('content')
<div class="best_sellers mt-5">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2 class="mb-0">Shopping Details</h2>
                    <hr>
                    <div class="d-flex justify-content-center"><span>You have {{(isset($product)) ? count($product) : 0}} items in your cart</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection