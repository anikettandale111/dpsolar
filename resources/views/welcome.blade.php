@extends('frontend.front')
<style>
    .product_name {
    margin-top: 10px !important;
}
</style>
@section('title', 'DPS')
@section('content')
<div class="main_slider" style="background-image:url({{asset('frontend/images/slider11.png')}})">
    <div class="container fill_height">
        <div class="row align-items-center fill_height">
            <div class="col">
                <div class="main_slider_content">
                    <h6 class="titleTextColor" id="text1">{{$firstTitleArray[rand(0,9)]}}</h6>
                    <h1 class="titleTextColor" style="font-size:40px !important;" id="text2">{{$secondTitleArray[rand(0,9)]}}</h1>
                    <!-- <div class="red_button shop_now_button"><a href="#">shop now</a></div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Banner -->
<!-- <a href="categories.html">Solar Charge Controllers</a> -->
<!-- <a href="categories.html">Solar Water Heaters</a> -->
<!-- <a href="categories.html">Solar Lighting</a> -->
<!-- <a href="categories.html">Solar Power Kits</a> -->
<!-- <a href="categories.html">Solar Generators</a> -->
<div class="banner">
    <div class="container">
        <div class="row">
            @if(isset($category) && count($category))
            @foreach($category AS $key => $cat)
                <div class="col-md-4">
                    <div class="banner_item align-items-center" style="background-image:url('{{url(Storage::url($cat->cat_image))}}')">
                        <div class="banner_category">
                            <a href="javascript:void(0)" class="titleTextColor">{{$cat->category_name}}</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</div>

<!-- New Arrivals -->

<div class="new_arrivals">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2>New Arrivals</h2>
                </div>
            </div>
        </div>
        @if(isset($category) && count($category))
        <div class="row align-items-center">
            <div class="col text-center">
                <div class="new_arrivals_sorting">
                    <ul class="arrivals_grid_sorting clearfix button-group filters-button-group">
                        <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center active is-checked" data-filter="*">all</li>
                        @foreach($category AS $key => $cat)
                            <li class="grid_sorting_button button d-flex flex-column justify-content-center align-items-center" data-filter=".{{strtolower(str_replace(' ','-',$cat->category_name))}}">{{$cat->category_name}}</li>
                        @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
        @endif
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
                        <div class="product-item mobile-style {{strtolower(str_replace(' ','-',$prod->category_name))}}">
                            <div class="product discount product_filter">
                                <div class="product_image">
                                    <img src="{{url(Storage::url(json_decode($prod->images)[0]))}}" alt="">
                                </div>
                                <div class="favorite favorite_left"></div>
                                <div class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center"><span>-{{config('app.currency')}} {{$prod->display_price -$prod->selling_price }}</span></div>
                                <div class="product_info" style="position: relative;top: 20px;height: 90px;">
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

<!-- Deal of the week -->

<div class="deal_ofthe_week">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="deal_ofthe_week_img">
                    <img src="{{asset('frontend/images/deal_ofthe_week.png')}}" alt="">
                </div>
            </div>
            <div class="col-lg-6 text-right deal_ofthe_week_col">
                <div class="deal_ofthe_week_content d-flex flex-column align-items-center float-right">
                    <div class="section_title">
                        <h2>Deal Of The Week</h2>
                    </div>
                    <ul class="timer">
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="day" class="timer_num">03</div>
                            <div class="timer_unit">Day</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="hour" class="timer_num">15</div>
                            <div class="timer_unit">Hours</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="minute" class="timer_num">45</div>
                            <div class="timer_unit">Mins</div>
                        </li>
                        <li class="d-inline-flex flex-column justify-content-center align-items-center">
                            <div id="second" class="timer_num">23</div>
                            <div class="timer_unit">Sec</div>
                        </li>
                    </ul>
                    <div class="red_button deal_ofthe_week_button"><a href="#">shop now</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Best Sellers -->

<div class="best_sellers">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2>Best Sellers</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="product_slider_container">
                    <div class="owl-carousel owl-theme product_slider">

                    <!-- Slide 1 -->
                    @if(isset($product) && count($product))
                        @foreach($product AS $key => $prod)
                        @php 
                        $hashedId = App\Helpers\DeviceHelper::generateHash($prod->pid);
                        @endphp
                        <div class="owl-item product_slider_item {{strtolower(str_replace(' ','-',$prod->category_name))}}">
                            <div class="product-item mobile-show mobile-style">
                                <div class="product discount product_filter">
                                    <div class="product_image">
                                        <img src="{{url(Storage::url(json_decode($prod->images)[0]))}}" alt="">
                                    </div>
                                    <div class="favorite favorite_left"></div>
                                    <div class="product_bubble product_bubble_right product_bubble_red d-flex flex-column align-items-center"><span>-{{config('app.currency')}} {{$prod->display_price -$prod->selling_price }}</span></div>
                                    <div class="product_info" style="position: relative;top: 15px;">
                                        <h6 class="product_name"><a href="{{URL('/products/'.$hashedId)}}">{{$prod->product_name}}</a></h6>
                                        <div class="product_price">{{config('app.currency')}} {{$prod->selling_price}}<span>{{config('app.currency')}} {{$prod->display_price}}</span></div>
                                    </div>
                                </div>
                                <div class="red_button add_to_cart_button" style="top:-40px;">add to cart</div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                    </div>
                    <!-- Slider Navigation -->
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
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function typeEffect(element, speed) {
            const text = element.innerHTML;
            element.innerHTML = "";
            let i = 0;

            function typing() {
                if (i < text.length) {
                    element.innerHTML += text.charAt(i);
                    i++;
                    setTimeout(typing, speed);
                } else {
                    element.classList.add('typing-complete'); // Add class when typing is complete
                }
            }
            typing();
        }
        const text1 = document.getElementById('text1');
        typeEffect(text1, 50); // Adjust speed as needed
        const text2 = document.getElementById('text2');
        typeEffect(text2, 50); // Adjust speed as needed
    });
</script>

@endpush