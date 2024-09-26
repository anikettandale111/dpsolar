<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
use App\Helpers\DeviceHelper;
@endphp

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('title')</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="app-url" id="app-url" content="{{ url('/') }}">
  <!-- General CSS Files -->
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/bootstrap4/bootstrap.min.css')}}">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.1.1/css/buttons.dataTables.css">
  <link href="{{ asset('frontend/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.theme.default.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/animate.css')}}">
  @if(isset($hide_main_css) && $hide_main_css == 1)
  @else
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/main_styles.css')}}">
  @endif
  <link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/responsive.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
  @stack('styles')
  <style>
    .account,
    .checkout a {
      background: none
    }

    .checkout_items {
      top: 30px;
      left: unset;
      width: 20px;
      height: 20px;
      margin-left: 10px
    }

    .account_selection li {
      padding-left: 3px;
      padding-right: 3px;
      line-height: 35px;
    }
    .account_selection{
      width: 130px !important;
    }

    .toast-bottom-custom {
      position: fixed;
      bottom: 20px;
      left: 20px;
      right: auto;
      top: auto
    }

    #loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, .8);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 9999
    }

    .spinner {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg)
      }

      100% {
        transform: rotate(360deg)
      }
    }

    #content.blurred {
      filter: blur(3px)
    }

    .required {
      color: red
    }

    @media screen and (max-width:767px) {
      .checkout a i {
        font-size: 20px;
        margin-left: 0 !important
      }

      .checkout span {
        font-size: 12px;
        font-weight: 900
      }

      .checkout_items {
        top: 10px;
        right: -5px;
        width: 20px;
        height: 20px
      }

      .account_selection li {
        padding-left: 3px;
        padding-right: 3px;
        line-height: 35px
      }
    }

    #text1,
    #text2 {
      white-space: normal;
      margin: 0 auto;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
      animation: 6s steps(60, end) typing, 6s color-change;
      position: relative
    }

    @keyframes typing {
      from {
        width: 0
      }

      to {
        width: 100%
      }
    }

    @keyframes blink-caret {

      from,
      to {
        border-color: transparent
      }

      50% {
        border-color: orange
      }
    }

    @keyframes color-change {
      0% {
        color: #000
      }

      50% {
        color: orange
      }

      100% {
        color: red
      }
    }

    .cursor {
      border-right: .15em solid orange;
      animation: .75s step-end infinite blink-caret;
      display: inline-block;
      position: absolute
    }

    .typing-complete .cursor {
      display: none
    }

    .titleTextColor {
      color: {{$colroarray[rand(0, 4)]}} !important
    }

    .payment-info {
      background: darkmagenta;
      /* background: #00f; */
      padding: 10px;
      border-radius: 6px;
      color: #fff;
      font-weight: 700
    }

    .product-details {
      padding: 10px
    }

    body {
      background: #eee
    }

    .cart {
      background: #fff
    }

    .p-about {
      font-size: 12px
    }

    .table-shadow {
      -webkit-box-shadow: 5px 5px 15px -2px rgba(0, 0, 0, .42);
      box-shadow: 5px 5px 15px -2px rgba(0, 0, 0, .42)
    }

    .type {
      font-weight: 400;
      font-size: 10px
    }

    label.radio {
      cursor: pointer
    }

    label.radio input {
      position: absolute;
      top: 0;
      left: 0;
      visibility: hidden;
      pointer-events: none
    }

    label.radio span {
      padding: 1px 12px;
      border: 2px solid #ada9a9;
      display: inline-block;
      color: #8f37aa;
      border-radius: 3px;
      text-transform: uppercase;
      font-size: 11px;
      font-weight: 300
    }

    label.radio input:checked+span {
      border-color: #fff;
      background-color: #00f;
      color: #fff
    }

    .credit-inputs {
      background: #66d;
      color: #fff !important;
      border-color: #66d
    }

    .credit-inputs::placeholder {
      color: #fff;
      font-size: 13px
    }

    .credit-card-label {
      font-size: 9px;
      font-weight: 300
    }

    .form-control.credit-inputs:focus {
      background: #66d;
      border: #66d
    }

    .line {
      border-bottom: 1px solid #66d
    }

    .information span {
      font-size: 12px;
      font-weight: 500
    }

    .information {
      margin-bottom: 5px
    }

    .items {
      -webkit-box-shadow: 5px 5px 4px -1px rgba(0, 0, 0, .25);
      box-shadow: 5px 5px 4px -1px rgba(0, 0, 0, .08)
    }

    .spec {
      font-size: 11px
    }

    .descwidth {
      width: 55%
    }

    .mobileimg {
      width: 35%;
      height: 35%
    }

    @media (max-width:767px) {
      .descwidth {
        width: 100%
      }

      .container {
        padding: 15px
      }

      .row.no-gutters {
        margin: 0
      }

      .product-details {
        padding: 0
      }

      .d-flex,
      .items {
        flex-direction: column;
        align-items: flex-start
      }

      .product-details h6 {
        font-size: 16px
      }

      .items img {
        width: 60px;
        margin-bottom: 10px
      }

      .items .d-flex.flex-row {
        width: 100%;
        align-items: flex-start
      }

      .items .font-weight-bold {
        margin-top: 10px;
        margin-bottom: 5px
      }

      .items i.fa-trash-o {
        margin-top: 10px
      }

      .payment-info {
        padding: 10px 15px
      }

      .credit-inputs,
      .payment-info .information span {
        font-size: 14px
      }

      .credit-card-label {
        font-size: 11px
      }

      .btn-block {
        display: block;
        width: 100%
      }
    }

    .btn-minus,
    .btn-plus {
      padding: 5px;
      color: #fff
    }

    .btn-plus {
      border: 1px solid green;
      border-radius: 25%;
      background: green
    }

    .btn-minus {
      border: 1px solid red;
      border-radius: 25%;
      background: red
    }

    .information {
      display: flex;
      justify-content: space-between;
      align-items: center
    }

    .information .left {
      text-align: left
    }

    .information .right {
      text-align: right
    }

    .banner {
      margin-top: 120px !important
    }

    @media only screen and (max-width:767px) {
      .banner {
        margin-top: 100px !important
      }
    }
    .add_to_cart_button{
        color: white;
        text-transform: uppercase;
        visibility: visible !important;
        opacity: 2 !important;
    }
    .product_filter{background: white;}
    .product-item{padding: 5px 5px 0px 0px;}
    .product_name{text-transform: uppercase;}
    .red_button{top:-20px;}
</style>
  <script>
    var currency = "{{ config('app.currency') }}";
  </script>
</head>

<body>
  <div class="super_container">
    <!-- Header -->
    <header class="header trans_300">
      <!-- Top Navigation -->
      <!-- <div class="top_nav">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <div class="top_nav_left">https://themewagon.github.io/coloshop/index.html</div>
            </div>
            <div class="col-md-6 text-right">
              <div class="top_nav_right">
                <ul class="top_nav_menu">
                  <li class="currency">
                    <a href="#">
                      usd
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="currency_selection">
                      <li><a href="#">cad</a></li>
                      <li><a href="#">aud</a></li>
                      <li><a href="#">eur</a></li>
                      <li><a href="#">gbp</a></li>
                    </ul>
                  </li>
                  <li class="language">
                    <a href="#">
                      English
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="language_selection">
                      <li><a href="#">French</a></li>
                      <li><a href="#">Italian</a></li>
                      <li><a href="#">German</a></li>
                      <li><a href="#">Spanish</a></li>
                    </ul>
                  </li>
                  <li class="account">
                    <a href="#">
                      My Account
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="account_selection">
                      <li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a></li>
                      <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a></li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- Main Navigation -->
      <div class="main_nav_container">
        <div class="container">
          <div class="row">
            <div class="col-lg-12 text-right">
              <div class="logo_container">
                <a href="{{url('')}}">DIgital Power <span>Solutions</span></a>
              </div>
              <nav class="navbar">
                <ul class="navbar_menu">
                  <li><a href="{{url('/')}}">home</a></li>
                  <li><a href="{{url('/productlist')}}">products</a></li>
                  <li><a href="#">about us</a></li>
                  <li><a href="{{url('/categorylist')}}">category</a></li>
                  <!-- <li><a href="#">blog</a></li> -->
                  <li><a href="{{url('/contact')}}">contact</a></li>
                  @if(DeviceHelper::isMobile() == false)
                  <li class="checkout">
                    <a href="{{url('/cart')}}" style="padding: 10px;">
                      <i class="fa fa-shopping-cart" aria-hidden="true" style="font-size: large;"></i>
                      <span id="checkout_items" class="checkout_items">0</span>
                    </a>
                  </li>
                  @endif
                </ul>
                <ul class="top_nav_menu">
                  @if(DeviceHelper::isMobile() == true)
                  <li class="account checkout">
                    <a href="{{url('/cart')}}" style="padding: 10px;">
                      <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                      <span id="checkout_items" class="checkout_items">0</span>
                    </a>
                  </li>
                  @endif
                  @if(isset(Auth::guard('customer')->user()->cust_id) && Auth::guard('customer')->user()->cust_id > 0)
                  <li class="account">
                    <a href="#">
                      {{Auth::guard('customer')->user()->first_name}}
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="account_selection">
                      <li><a href="{{url('/customer/address')}}">My-Address</a></li>
                      <li><a href="{{url('/customer/address')}}">My-Address</a></li>
                      <!-- <li><a href="{{url('/customer/profile')}}">Profile</a></li> -->
                      <li>
                        <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit" style="background: none;border: none;">Logout</button>
                        </form>
                      </li>
                    </ul>
                  </li>
                  @elseif(isset(Auth::user()->id) && Auth::user()->id > 0)
                  <li class="account">
                    <a href="#">
                      {{Auth::user()->name}}
                      <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="account_selection">
                      <li>
                        <form action="{{ route('logout') }}" method="POST">
                          @csrf
                          <button type="submit" style="background: none;border: none;">Logout</button>
                        </form>
                      </li>
                    </ul>
                  </li>
                  @else
                  <li class="account">
                    <a href="#">Account<i class="fa fa-angle-down"></i></a>
                    <ul class="account_selection">
                      <li><a href="{{url('/login')}}"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a></li>
                      <li><a href="{{url('/register')}}"><i class="fa fa-user-plus" aria-hidden="true"></i>Register</a></li>
                    </ul>
                  </li>
                  @endif
                </ul>
                <div class="hamburger_container">
                  <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="fs_menu_overlay"></div>
    <div class="hamburger_menu">
      <div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
      <div class="hamburger_menu_content text-right">
        <ul class="menu_top_nav">
          <li class="menu_item"><a href="{{url('/')}}">home</a></li>
          <li class="menu_item"><a href="{{url('/productlist')}}">products</a></li>
          <li class="menu_item"><a href="#">about us</a></li>
          <li class="menu_item"><a href="{{url('/categorylist')}}">category</a></li>
          <li class="menu_item"><a href="{{url('/contact')}}">contact</a></li>
        </ul>
      </div>
    </div>
    <!-- Slider -->
    @yield('content')
    <!-- Benefit -->
    <div class="benefit">
      <div class="container">
        <div class="row benefit_row">
          <div class="col-lg-3 benefit_col">
            <div class="benefit_item d-flex flex-row align-items-center">
              <div class="benefit_icon"><i class="fa fa-truck" aria-hidden="true"></i></div>
              <div class="benefit_content">
                <h6>free shipping</h6>
                <p>Suffered Alteration in Some Form</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 benefit_col">
            <div class="benefit_item d-flex flex-row align-items-center">
              <div class="benefit_icon"><i class="fa fa-money" aria-hidden="true"></i></div>
              <div class="benefit_content">
                <h6>cach on delivery</h6>
                <p>The Internet Tend To Repeat</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 benefit_col">
            <div class="benefit_item d-flex flex-row align-items-center">
              <div class="benefit_icon"><i class="fa fa-undo" aria-hidden="true"></i></div>
              <div class="benefit_content">
                <h6>45 days return</h6>
                <p>Making it Look Like Readable</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 benefit_col">
            <div class="benefit_item d-flex flex-row align-items-center">
              <div class="benefit_icon"><i class="fa fa-clock-o" aria-hidden="true"></i></div>
              <div class="benefit_content">
                <h6>opening all week</h6>
                <p>8AM - 09PM</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if('display' == 1)
    <!-- Blogs -->
    <!-- <div class="blogs">
	    <div class="container">
	        <div class="row">
	            <div class="col text-center">
	                <div class="section_title">
	                    <h2>Latest Blogs</h2>
	                </div>
	            </div>
	        </div>
	        <div class="row blogs_container">
	            <div class="col-lg-4 blog_item_col">
	                <div class="blog_item">
	                    <div class="blog_background" style="background-image:url('{{asset('frontend/images/blog_1.jpg')}}')"></div>
	                    <div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
	                        <h4 class="blog_title">Here are the trends I see coming this fall</h4>
	                        <span class="blog_meta">by admin | dec 01, 2017</span>
	                        <a class="blog_more" href="#">Read more</a>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-4 blog_item_col">
	                <div class="blog_item">
	                    <div class="blog_background" style="background-image:url('{{asset('frontend/images/blog_2.jpg')}}')"></div>
	                    <div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
	                        <h4 class="blog_title">Here are the trends I see coming this fall</h4>
	                        <span class="blog_meta">by admin | dec 01, 2017</span>
	                        <a class="blog_more" href="#">Read more</a>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-4 blog_item_col">
	                <div class="blog_item">
	                    <div class="blog_background" style="background-image:url('{{asset('frontend/images/blog_3.jpg')}}')"></div>
	                    <div class="blog_content d-flex flex-column align-items-center justify-content-center text-center">
	                        <h4 class="blog_title">Here are the trends I see coming this fall</h4>
	                        <span class="blog_meta">by admin | dec 01, 2017</span>
	                        <a class="blog_more" href="#">Read more</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div> -->


    <!-- Newsletter -->
    <!-- <div class="newsletter">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="newsletter_text d-flex flex-column justify-content-center align-items-lg-start align-items-md-center text-center">
              <h4>Newsletter</h4>
              <p>Subscribe to our newsletter and get 20% off your first purchase</p>
            </div>
          </div>
          <div class="col-lg-6">
            <form action="post">
              <div class="newsletter_form d-flex flex-md-row flex-column flex-xs-column align-items-center justify-content-lg-end justify-content-center">
                <input id="newsletter_email" type="email" placeholder="Your email" required="required" data-error="Valid email is required.">
                <button id="newsletter_submit" type="submit" class="newsletter_submit_btn trans_300" value="Submit">subscribe</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div> -->
    @endif
    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-6">
            <div class="footer_social d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center">
              <ul class="footer_nav">
                <li><a href="#">Blog</a></li>
                <li><a href="#">FAQs</a></li>
                <li><a href="{{url('/contact')}}">Contact us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="footer_social d-flex flex-row align-items-center justify-content-lg-end justify-content-center">
              <ul>
                <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="footer_nav_container">
              <div class="cr">
                <center>©{{date('Y')}} All Rights Reserverd.<br> Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://www.codedesiretechnologies.com/">Code Desire Technology</a></center>
              </div>
            </div>
          </div>
        </div>
    </footer>
  </div>
    <script src="{{ asset('frontend/js/jquery-3.2.1.min.js')}}"></script>
  <script src="{{ asset('frontend/styles/bootstrap4/popper.js')}}"></script>
  <script src="{{ asset('frontend/styles/bootstrap4/bootstrap.min.js')}}"></script>
  <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.dataTables.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.html5.min.js"></script>
  <script src="{{ asset('frontend/plugins/Isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('frontend/plugins/OwlCarousel2-2.2.1/owl.carousel.js')}}"></script>
  <script src="{{ asset('frontend/plugins/easing/easing.js')}}"></script>
  <script src="{{ asset('frontend/js/custom.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
  @stack('scripts')
</body>

</html>