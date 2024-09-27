@extends('frontend.front')
@section('title', 'Product')
@push('styles')
<style>
    .red_button {
        top: -5px !important;
    }
</style>
@endpush
@section('content')

<div class="banner">
    <div class="container">
        <div class="col text-center">
            <div class="section_title new_arrivals_title">
                <h2>Categories</h2>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="product_slider_container cat_container">
                    <div class="owl-carousel owl-theme product_slider">
                        @if(isset($categorylist) && count($categorylist))
                        @foreach($categorylist AS $key => $cat)
                        @php
                        $hashedId = App\Helpers\DeviceHelper::generateHash($cat->id);
                        @endphp
                        <div class="owl-item product_slider_item">
                            <div class="product-item mobile-show mobile-style">
                                <div class="product discount product_filter">
                                    <div class="product_image category_image banner_item align-items-center">
                                        <img src="{{url(Storage::url($cat->cat_image))}}" alt="">
                                    </div>
                                    <div class="product_info banner_category">
                                        <h6 class="product_name"><a href="{{URL('/category/'.$hashedId)}}" class="titleTextColor">{{$cat->category_name}}</a></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="product_slider_nav_left product_slider_nav d-flex align-items-center justify-content-center flex-column">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                    </div>
                    <div class="product_slider_nav_right product_slider_nav d-flex align-items-center justify-content-center flex-column">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="new_arrivals">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2>{{$category}}</h2>
                </div>
            </div>
        </div>
        <!-- @if(isset($categorylist) && count($categorylist))
        <div class="row align-items-center">
            <div class="col text-center">
                <div class="new_arrivals_sorting">
                    <ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                        @foreach($categorylist AS $key => $cat)
                        @php $active = ($category == $cat->category_name)?'active':'' @endphp
                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center {{$active}}" data-filter=".{{strtolower(str_replace(' ','-',$cat->category_name))}}">{{$cat->category_name}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif -->

        <div class="row">
            <div class="col">
                <div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>
                    <!-- Product 1 -->
                    @if(isset($product) && count($product))
                    @foreach($product AS $key => $prod)
                    @php
                    $hashedId = App\Helpers\DeviceHelper::generateHash($prod->pid);
                    @endphp
                    <a href="{{URL('/products/'.$hashedId)}}">
                        <div class="product-item {{strtolower(str_replace(' ','-',$prod->category_name))}}">
                            <div class="product discount product_filter">
                                <div class="product_image">
                                    <img src="{{url(Storage::url(json_decode($prod->images)[0]))}}" alt="">
                                </div>
                                <div class="favorite favorite_left"></div>
                                <div class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center"><span>-{{config('app.currency')}} {{$prod->display_price -$prod->selling_price }}</span></div>
                                <div class="product_info">
                                    <h6 class="product_name">{{$prod->product_name}}</h6>
                                    <div class="product_price">{{config('app.currency')}} {{$prod->selling_price}}<span>{{config('app.currency')}} {{$prod->display_price}}</span></div>
                                </div>
                            </div>
                            <div class="red_button add_to_cart_button">add to cart</div>
                        </div>
                    </a>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection