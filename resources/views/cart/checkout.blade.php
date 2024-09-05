@extends('frontend.front')
@section('title', 'Checkout')
@section('content')
<div class="best_sellers mt-5">
    <div class="container">
    </div>
</div>
<h3>{{(isset($message->message)) ? $message->message : $message['message']}}</h3>
@endsection
@push('scripts')
<script src="{{ asset('frontend/js/single_custom.js') }}"></script>
@endpush