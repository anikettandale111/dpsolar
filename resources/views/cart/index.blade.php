@extends('frontend.front')

@php
$prodtot=0.00;
$grandtot=0.00;
@endphp
@section('title', 'Cart Detail')
<style>
    select.form-control {
        width: 100%;
        white-space: nowrap;
        overflow-x: hidden;
        text-overflow: ellipsis;
        display: block;
    }

    select.form-control option {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }

    #delivery_address {
        width: 100%;
        border-radius: 10px;
        padding: 3px;
    }

    .form-check-input {
        background-color: #023047;
    }

    .removeitem i {
        margin: 5px 5px 5px 0px;
        position: relative;
        right: 5px;
        color: white;
    }

    .removeitem {
        background: red;
        border-radius: 50px;
        margin: 5px 5px 5px 9px;
        position: relative;
        left: 10px;
        border: none;
        font-size: 15px;
    }
</style>
@section('content')

<!-- Best Sellers -->

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
        @if(isset($product) && count($product))
        <div class="container rounded cart">
            <div class="row no-gutters">
                <div class="col-md-9 mb-2">
                    <div class="product-details mr-2">
                        <!-- <div class="d-flex flex-row align-items-center"><i class="fa fa-long-arrow-left"></i><span class="ml-2">Continue Shopping</span></div> -->
                        @foreach($product AS $key => $prod)
                        @php
                        $hashedId = App\Helpers\DeviceHelper::generateHash($prod['prod_id']);
                        $prodtot = $prod['sel_price']*$prod['quantity'];
                        $grandtot += $prodtot;
                        @endphp
                        <div class="quantity d-flex justify-content-between align-items-center mt-3 p-2 items rounded">
                            <div class="descwidth">
                                <a href="{{URL('/products/'.$hashedId)}}">
                                    <div class="d-flex flex-row"><img class="rounded mobileimg" src="{{url(Storage::url($prod['image']))}}" width="40">
                                        <div class="ml-2 "><span class="font-weight-bold d-block">{{$prod['prod_name']}}</span><span class="spec">{{(isset($prod['description'])) ? $prod['description'] :''}}</span></div>
                                    </div>
                                </a>
                            </div>
                            <div class="d-flex flex-row align-items-center"><span class="d-block font-weight-bold {{$hashedId}}">{{config('app.currency')}} {{number_format($prod['sel_price'],2) }}</span>
                                <div class="row quantity_selector ml-3">
                                    <span class="minus btn-minus mr-3"><i class="fa fa-minus" aria-hidden="true" onclick="minusCal('{{$hashedId}}')"></i></span>
                                    <span class="mr-3" id="quantity_value_{{$hashedId}}" data-pid="{{$hashedId}}">{{$prod['quantity']}}</span>
                                    <span class="plus btn-plus" onclick="plusCal('{{$hashedId}}')"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                </div>
                                <span class=""></span><span class="d-block ml-5 font-weight-bold" id="total_price_{{$hashedId}}">{{config('app.currency')}} {{number_format($prodtot,2) }}</span><button type="button" class="removeitem" data-hashid="{{$hashedId}}"><i class="fa fa-trash-o ml-3 text-black-50"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div id="loader" style="display: none;">
                    <div class="spinner"></div>
                </div>
                <div id="content"></div>
                <div class="col-md-3 mt-5">
                    <div class="payment-info">
                        <div class="d-flex justify-content-between align-items-center"><span>Checkout Details</span>
                            <!-- <img class="rounded" src="https://i.imgur.com/WU501C8.jpg" width="30"> -->
                        </div>
                        @php
                        $redirecturl = (isset(Auth::guard('customer')->user()->cust_id) && Auth::guard('customer')->user()->cust_id > 0) ? 'cart/checkout':'login';
                        @endphp
                        <form action="{{url($redirecturl)}}" method="POST" id="checksubform">
                            @csrf
                            <label class="credit-card-label">Payment Method</label><br>
                            <input class="form-check-input ml-3" type="radio" name="payment_method" id="upi" value="UPI" checked required>
                            <label class="form-check-label ml-3" for="upi">Online</label><br>
                            <input class="form-check-input ml-3" type="radio" name="payment_method" id="cod" value="COD" required>
                            <label class="form-check-label ml-3" for="cod">Cash on Delivery (COD)</label>
                            @if(isset(Auth::guard('customer')->user()->cust_id) && Auth::guard('customer')->user()->cust_id > 0)
                            <label class="credit-card-label">Select Delivery Address</label>
                            <select class="form-control" id="delivery_address" name="delivery_address" required>
                                <option selected disabled class="">Select Delivery Address</option>
                                @if(isset($address) && count($address))
                                @foreach($address AS $key => $add)
                                @php
                                $hashedId = App\Helpers\DeviceHelper::generateHash($add['aid']);
                                @endphp
                                <option value="{{$hashedId}}">{{$add['address_one'].' '.$add['address_two'].' '.$add['address_three']}}{{$add['city'].' '.$add['state'].' '.$add['pincode']}}</option>
                                @endforeach
                                @endif
                            </select>
                            <a class="credit-card-label pull-right" style="color:white" href="{{url('customer/address')}}"><u>Manage Address</u></a>
                            @endif
                            <br>
                            <br>
                            <!-- <hr class="line"> -->
                            <div class="information"><span class="left">Net Amount</span><span class="netamount right">{{config('app.currency')}}0.00</span></div>
                            <div class="information"><span class="left">GST</span><span class="gstamount">{{config('app.currency')}}0.00</span></div>
                            <div class="information"><span class="left">Shipping Charges</span><span class="shippingamt right">{{config('app.currency')}}0.00</span></div>
                            <div class="information"><span class="left">Total(Incl. taxes)</span><span class="totalamt right">{{config('app.currency')}}0.00</span></div>
                            @if(isset(Auth::guard('customer')->user()->cust_id) && Auth::guard('customer')->user()->cust_id > 0)
                            <button class="btn btn-primary btn-block mt-3" id="checksub" type="submit">
                                <div class="information">
                                    <span class="finalamt left totalamt">{{config('app.currency')}} {{number_format($grandtot,2)}}</span>
                                    <span class="right">Checkout<i class="fa fa-long-arrow-right ml-1"></i></span>
                                </div>
                            </button>
                        </form>
                        @else
                        <a href="{{url('/login')}}" class="btn btn-primary btn-block mt-3" type="button">
                            <div class="information">
                                <span class="finalamt left totalamt">{{config('app.currency')}} {{number_format($grandtot,2)}}</span>
                                <span class="right">Checkout<i class="fa fa-long-arrow-right ml-1"></i></span>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('frontend/js/single_custom.js') }}"></script>
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
    getcarttotalcal();
    var APP_URL = $('#app-url').attr("content");
    $(document).ready(function() {
        $('#checksub').on('click', function(event) {
            event.preventDefault();
            if ($('#delivery_address').val() === null) {
                toastr.error('Select Delivery Address');
                return false;
            } else {
                $('#checksubform').submit();
            }
        });
        $('.removeitem').on('click', function(event) {
            if(confirm('Are you Sure ?')){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: APP_URL + '/cart/deleteitem/' + $(this).data('hashid'), // Replace with your form action URL
                    type: 'DELETE',
                    dataType: 'json',
                    success: function(response) {
                        toastr.success(response.message);
                        location.reload();
                    }
                });
            }
        });
    });
</script>
@endpush