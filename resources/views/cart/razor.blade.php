@extends('frontend.front')
@section('title', 'Razorpay Payment')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-center pt-70 pb-70 flex-column align-items-center">
                <h3>Razor Payment</h3><br>
                <div id="loader" style="display: none;">
                    <div class="spinner"></div>
                    <span>Please wait while we generate your invoice.</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function showLoader() {
      $('#loader').show();
    }
    $(document).ready(function() {
        showLoader();
        var APP_URL = $('#app-url').attr("content");
        var options = {
            "key": "{{$razor_key_id}}", // Enter the Key ID generated from the Dashboard
            "amount": '{{ $totalamt }}', // Amount is in currency subunits. Default currency is INR. Hence, 10 refers to 1000 paise
            "currency": "INR",
            "name": "{{config('app.name')}}",
            "description": "Order Payment",
            "image": "{{url('frontend/assets/images/60-80.svg')}}",
            "order_id": "{{$razor_order_id}}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
            "handler": function(response) {
                var token = "{{ csrf_token() }}";
                $.ajax({
                    type: 'POST',
                    url: APP_URL+"/cart/payment",
                    data: {
                        _token: token,
                        payment_response: JSON.stringify(response)
                    },
                    success: function(data) {
                        window.location.href = APP_URL+"/cart/complete";
                    }
                });
            },
            "prefill": {
                "name": "{{ Auth::guard('customer')->user()->first_name }} {{ Auth::guard('customer')->user()->first_namelast_name }}",
                "email": "{{ Auth::guard('customer')->user()->email }}",
                "contact": "{{ Auth::guard('customer')->user()->mobile_num }}"
            },
            "notes": {
                "address": "test test"
            },
            "theme": {
                "color": "#F37254"
            },
            "modal": {
                "ondismiss": function(){
                    // Handle modal close event (user canceled the payment)
                    window.location.href = APP_URL+"/cart";
                    // You can perform actions like redirecting the user or showing a custom message
                }
            }
        };
        var rzp1 = new Razorpay(options);
        rzp1.open();
    });
</script>
@endpush