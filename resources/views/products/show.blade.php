@extends('frontend.front')
@section('title', 'Product Information')
@php
use App\Helpers\DeviceHelper;
@endphp
@push('styles')
@if(DeviceHelper::isMobile())
<link rel="stylesheet" href="{{ asset('frontend/css/single_styles.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/single_responsive.css') }}">
@else
<link rel="stylesheet" href="{{ asset('frontend/css/single_styles.css') }}">
@endif
@endpush
@section('content')
<div class="container single_product_container">
    <div class="row">
        <div class="col">
            <!-- Breadcrumbs -->
            <div class="breadcrumbs d-flex flex-row align-items-center">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="categories.html"><i class="fa fa-angle-right" aria-hidden="true"></i>Men's</a></li>
                    <li class="active"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i>Single Product</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        @if(isset($product->images) && count(json_decode($product->images)))
        <div class="col-lg-7">
            <div class="single_product_pics">
                <div class="row">
                    <div class="col-lg-3 thumbnails_col order-lg-1 order-2">
                        <div class="single_product_thumbnails">
                            <ul>
                                @php $prod_images = json_decode($product->images); @endphp
                                @foreach($prod_images AS $key => $prodimg)
                                <li @if($key==0) class="active" @endif><img src="{{url(Storage::url($prodimg))}}" alt="" data-image="{{url(Storage::url($prodimg))}}"></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-9 image_col order-lg-2 order-1">
                        <div class="single_product_image">
                            <div class="single_product_image_background" style="background-image:url('{{url(Storage::url($prod_images[0]))}}')"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-lg-5">
            <div class="product_details">
                <div class="product_details_title">
                    <h2>{{$product->product_name}}</h2>
                    <p>{{$product->description}}</p>
                </div>
                <div class="free_delivery d-flex flex-row align-items-center justify-content-center">
                    <span class="ti-truck"></span><span>free delivery</span>
                </div>
                <div class="original_price">{{config('app.currency')}} {{$product->display_price}}</div>
                <div class="product_price">{{config('app.currency')}} {{$product->selling_price}}</div>
                <ul class="star_rating">
                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                    <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                </ul>
                <!-- <div class="product_color">
						<span>Select Color:</span>
						<ul>
							<li style="background: #e54e5d"></li>
							<li style="background: #252525"></li>
							<li style="background: #60b3f3"></li>
						</ul>
					</div> -->
                    @php
                        $hashedId = App\Helpers\DeviceHelper::generateHash($product->pid);
                    @endphp
                <div class="quantity d-flex flex-column flex-sm-row align-items-sm-center">
                    <span>Quantity:</span>
                    <div class="quantity_selector">
                        <span class="minus"><i class="fa fa-minus" aria-hidden="true"></i></span>
                        <span id="quantity_value" data-pid="{{$hashedId}}">1</span>
                        <span class="plus"><i class="fa fa-plus" aria-hidden="true"></i></span>
                    </div>
                    <div class="red_button add_to_cart_button"><a href="javascript:void(0)">add to cart</a></div>
                    <!-- <div class="product_favorite d-flex flex-column align-items-center justify-content-center"></div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tabs_section_container">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="tabs_container">
                    <ul class="tabs d-flex flex-sm-row flex-column align-items-left align-items-md-center justify-content-center">
                        <li class="tab active" data-active-tab="tab_1"><span>Description</span></li>
                        <li class="tab" data-active-tab="tab_2"><span>Additional Information</span></li>
                        @if(isset($reviews) && count($reviews))
                            <li class="tab" data-active-tab="tab_3"><span>Reviews (2)</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">

                <!-- Tab Description -->

                <div id="tab_1" class="tab_container active">
                    <div class="row">
                        <div class="col-lg-5 desc_col">
                            <div class="tab_title">
                                <h4>Description</h4>
                            </div>
                            <div class="tab_text_block">
                                <h2>Pocket cotton sweatshirt</h2>
                                <p>Nam tempus turpis at metus scelerisque placerat nulla deumantos solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis ut...</p>
                            </div>
                            <div class="tab_image">
                                <img src="{{url(Storage::url($prod_images[0]))}}" alt="">
                            </div>
                            <div class="tab_text_block">
                                <h2>Pocket cotton sweatshirt</h2>
                                <p>Nam tempus turpis at metus scelerisque placerat nulla deumantos solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis ut...</p>
                            </div>
                        </div>
                        <div class="col-lg-5 offset-lg-2 desc_col">
                            <div class="tab_image">
                                <img src="{{url(Storage::url($prod_images[0]))}}" alt="">
                            </div>
                            <div class="tab_text_block">
                                <h2>Pocket cotton sweatshirt</h2>
                                <p>Nam tempus turpis at metus scelerisque placerat nulla deumantos solicitud felis. Pellentesque diam dolor, elementum etos lobortis des mollis ut...</p>
                            </div>
                            <div class="tab_image desc_last">
                                <img src="{{url(Storage::url($prod_images[0]))}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Additional Info -->

                <div id="tab_2" class="tab_container">
                    <div class="row">
                        <div class="col additional_info_col">
                            <div class="tab_title additional_info_title">
                                <h4>Additional Information</h4>
                            </div>
                            <p>COLOR:<span>{{$product->color}}</span></p>
                            <p>SIZE:<span>{{$product->size}}</span></p>
                            <p>WEIGHT:<span>{{$product->weight}}</span></p>
                            <p>HEIGHT:<span>{{$product->height}}</span></p>
                        </div>
                    </div>
                </div>

                <!-- reviews start -->
                @if(isset($reviews) && count($reviews))
                <div id="tab_3" class="tab_container">
                    <div class="row">

                        <!-- User Reviews -->

                        <div class="col-lg-6 reviews_col">
                            <div class="tab_title reviews_title">
                                <h4>Reviews ({{count($reviews)}})</h4>
                            </div>
                            <!-- User Review -->
                            @foreach($reviews AS $key => $rev)
                            <div class="user_review_container d-flex flex-column flex-sm-row">
                                <div class="user">
                                    <div class="user_pic"></div>
                                    <div class="user_rating">
                                        <ul class="star_rating">
                                            @for($i=0;$i < 5 ;$i++ )
                                                @if($i < $rev->rating)
                                                    <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                @else
                                                    <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                                @endif
                                            @endfor
                                        </ul>
                                    </div>
                                </div>
                                <div class="review">
                                    <div class="review_date">{{date('d M Y', strtotime($rev->created_at))}}</div>
                                    <div class="user_name">{{$rev->user_name}}</div>
                                    <p>{{$rev->description}}</p>
                                </div>
                            </div>
                            @endforeach
                            <!-- User Review -->
                        </div>

                        <!-- Add Review -->

                        <div class="col-lg-6 add_review_col">

                            <div class="add_review">
                                <form id="review_form" action="post">
                                    <div>
                                        <h1>Add Review</h1>
                                        <input id="review_name" class="form_input input_name" type="text" name="name" placeholder="Name*" required="required" data-error="Name is required.">
                                        <input id="review_email" class="form_input input_email" type="email" name="email" placeholder="Email*" required="required" data-error="Valid email is required.">
                                    </div>
                                    <div>
                                        <h1>Your Rating:</h1>
                                        <ul class="user_star_rating">
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                            <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                        </ul>
                                        <textarea id="review_message" class="input_review" name="message" placeholder="Your Review" rows="4" required="" data-error="Please, leave us a review."></textarea>
                                    </div>
                                    <div class="text-left text-sm-right">
                                        <button id="review_submit" type="submit" class="red_button review_submit_btn trans_300" value="Submit">submit</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
                @endif <!-- reviews end -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('frontend/js/single_custom.js') }}"></script>
@endpush