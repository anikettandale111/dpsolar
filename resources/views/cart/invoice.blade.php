@extends('frontend.front')
@php
use App\Helpers\DeviceHelper;
@endphp
@section('title', 'Cart Detail')
@push('styles')
<!-- External CSS libraries -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/styles/bootstrap4/bootstrap.min.css')}}">
<link href="{{ asset('frontend/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">
<!-- Favicon icon -->
<link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
<!-- Google fonts -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<!-- Custom Stylesheet -->
<link rel="stylesheet" type="text/css" href="{{ asset('frontend/css/invoice.css')}}">
<style>
    .showlarge:hover{
        transform: scale(5.5);
    }
</style>
@endpush

@section('content')
<!-- Invoice 6 start -->
@if(DeviceHelper::isMobile() == false)
@else
@endif
<div class="invoice-6 invoice-content mt-5 d-flex flex-wrap justify-content-between">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <div class="invoice-btn-section clearfix d-print-none">
                        <a href="javascript:window.print()" class="btn btn-lg btn-print">
                            <i class="fa fa-print"></i> Print Invoice
                        </a>
                        <a id="invoice_download_btn" class="btn btn-lg btn-download btn-theme">
                            <i class="fa fa-download"></i> Download Invoice
                        </a>
                    </div>
                <div class="invoice-inner clearfix">
                    <div class="invoice-info clearfix" id="invoice_wrapper">
                        <div class="invoice-headar">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="invoice-logo">
                                        <div class="logo">
                                            <img src="{{ asset('frontend/images/dps_logo.jpeg')}}" alt="logo">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="invoice-contact-us">
                                        <h1>Contact Us</h1>
                                        <ul class="link">
                                            <li><i class="fa fa-map-marker"></i> Dhatrak Phata, Panchavati, Nashik, Maharashtra</li>
                                            <li><i class="fa fa-envelope"></i><a href="mailto:sales@hotelempire.com">info@dreampowersolutions.com</a></li>
                                            <li><i class="fa fa-phone"></i> <a href="tel:+55-417-634-7071">+91-89895-89895</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="invoice-contant">
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2 class="name">Invoice No: </h2>
                                        <p>{{$order->order_id}}</p>
                                    </div>
                                    <div class="col-sm-6 mb-30">
                                        <div class="invoice-number-inner">
                                            <h2 class="name">Invoice Date: </h2>
                                            <p>{{date('Y-m-d h:i A',strtotime($order->created_at))}}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-30">
                                        <div class="invoice-number">
                                            <h4 class="inv-title-1">Invoice To</h4>
                                            <h2 class="name mb-10">{{Auth::guard('customer')->user()->first_name." ".Auth::guard('customer')->user()->last_name}}</h2>
                                            <p class="invo-addr-1 mb-0"><b>Address: </b>{{$order->delivery_address}}</p>
                                            <p class="invo-addr-1 mb-0"><b>Mobile: </b>{{Auth::guard('customer')->user()->mobile_num}}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-30">
                                        <div class="payment-method mb-30">
                                            <h3 class="inv-title-1 mb-10">Payment Details</h3>
                                            <ul class="payment-method-list-1 text-14">
                                                <li style="text-transform: uppercase;"><strong>Method:</strong> {{$order->payment_type}}</li>
                                                <li style="text-transform: uppercase;"><strong>Status:</strong> {{$order->payment_status}}</li>
                                                <!-- <li><strong>Branch Name:</strong> xyz</li> -->
                                            </ul>
                                        </div>
                                        <div class="payment-method mb-30">
                                            <h3 class="inv-title-1 mb-10">Order Status</h3>
                                            <ul class="payment-method-list-1 text-14">
                                                @php
                                                if($order->order_status == 'Not Accepted'){
                                                    $btnclass ='btn btn-secondary';
                                                }elseif($order->order_status == 'Accepted'){
                                                    $btnclass ='btn btn-primary';
                                                }elseif($order->order_status == 'Delivered'){
                                                    $btnclass ='btn btn-success';
                                                }
                                                @endphp 
                                                <li style="text-transform: uppercase;" class="{{$btnclass}}"> {{$order->order_status}}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6 mb-30">
                                            <div class="invoice-number">
                                                <div class="invoice-number-inner">
                                                    <h4 class="inv-title-1">Invoice From</h4>
                                                    <h2 class="name mb-10">Animas Roky</h2>
                                                    <p class="invo-addr-1 mb-0">
                                                        Apexo Inc <br />
                                                        billing@apexo.com <br />
                                                        169 Teroghoria, Bangladesh <br />
                                                    </p>
                                                </div>
                                            </div>
                                        </div> -->
                                </div>
                            </div>
                            <div class="invoice-center">
                                <div class="order-summary">
                                    <div class="table-outer">
                                        <table class="default-table invoice-table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Image</th>
                                                    <th>Quantity</th>
                                                    <th>Rate</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            @php $prodtot=0.00;
                                            $grandtot=0.00; @endphp
                                            <tbody>
                                                @foreach($orderProduct AS $key => $prod)
                                                @php
                                                $hashedId = App\Helpers\DeviceHelper::generateHash($prod->prod_id);
                                                $prodtot = $prod->price * $prod->quantity;
                                                $grandtot += $prodtot;
                                                @endphp
                                                <tr>
                                                    <td><a href="{{URL('/products/'.$hashedId)}}">{{$prod->prod_name}}</a></td>
                                                    <td><a href="{{URL('/products/'.$hashedId)}}">
                                                            <img class="rounded showlarge" src="{{url(Storage::url($prod->image))}}" width="40">
                                                        </a>
                                                    </td>
                                                    <td>{{$prod->quantity}} </td>
                                                    <td>{{config('app.currency')}} {{$prod->price}}</td>
                                                    <td>{{config('app.currency')}} {{$prod->total_price}} </td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <td colspan='4'><span class="left">GST</span></td>
                                                    <td><span class="gstamount">{{config('app.currency')}} {{number_format(round($order->cgst+$order->sgst),2)}}</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan='4'><span class="left">Shipping Charges</span></td>
                                                    <td><span class="shippingamt right">{{config('app.currency')}} {{number_format($order->shipping_charge,2)}}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan='4'><span class="left">Total(Incl. taxes)</span></td>
                                                    <td><span class="totalamt right">{{config('app.currency')}} {{number_format($order->payment_amount,2)}}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-bottom">
                                <div class="row">
                                    <div class="col-lg-7 col-md-7 col-sm-7">
                                        <div class="terms-conditions mb-30">
                                            <h3 class="inv-title-1 mb-10">Terms & Conditions</h3>
                                            <ul class="payment-method-list-1 text-14">
                                                <li>Order Can not be Cancelled.</li>
                                                <li>Order will be deliver in 3 working days.</li>
                                                <li>Physical Damaged Can Not be Recovered.</li>
                                                <!-- <li><strong>Branch Name:</strong> xyz</li> -->
                                            </ul>
                                        </div>
                                    </div>
                                    <!-- <div class="col-lg-5 col-md-5 col-sm-5">
                                            <div class="payment-method mb-30">
                                                <h3 class="inv-title-1 mb-10">Payment Details</h3>
                                                <ul class="payment-method-list-1 text-14">
                                                    <li style="text-transform: uppercase;"><strong>Method:</strong> {{$order->payment_type}}</li>
                                                    <li style="text-transform: uppercase;"><strong>Status:</strong> {{$order->payment_status}}</li>
                                                    <li><strong>Branch Name:</strong> xyz</li>
                                                </ul>
                                            </div>
                                        </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- Invoice 6 end -->
<script src="{{ asset('frontend/js/jquery-3.2.1.min.js')}}"></script>
<script src="{{ asset('frontend/js/jspdf.min.js')}}"></script>
<script src="{{ asset('frontend/js/html2canvas.js')}}"></script>
<script>
    $(function() {
        'use strict';
        $(document).on('click', '#invoice_download_btn', function() {
            var contentWidth = $("#invoice_wrapper").width();
            var contentHeight = $("#invoice_wrapper").height();
            var topLeftMargin = 20;
            var pdfWidth = contentWidth + (topLeftMargin * 2);
            var pdfHeight = (pdfWidth * 1.5) + (topLeftMargin * 2);
            var canvasImageWidth = contentWidth;
            var canvasImageHeight = contentHeight;
            var totalPDFPages = Math.ceil(contentHeight / pdfHeight) - 1;

            html2canvas($("#invoice_wrapper")[0], {
                allowTaint: true
            }).then(function(canvas) {
                canvas.getContext('2d');
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [pdfWidth, pdfHeight]);
                pdf.addImage(imgData, 'JPG', topLeftMargin, topLeftMargin, canvasImageWidth, canvasImageHeight);
                for (var i = 1; i <= totalPDFPages; i++) {
                    pdf.addPage(pdfWidth, pdfHeight);
                    pdf.addImage(imgData, 'JPG', topLeftMargin, -(pdfHeight * i) + (topLeftMargin * 4), canvasImageWidth, canvasImageHeight);
                }
                pdf.save("sample-invoice.pdf");
            });
        });
    })
</script>
@endpush