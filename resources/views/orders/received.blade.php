@extends('layouts.back')
@section('title', 'Manage Orders')
@push('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Received Orders</h4>
          <div class="table-responsive">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-striped table-bordered zero-configuration">
                  <thead>
                    <tr>
                      <!-- <th scope="col">S#</th> -->
                      <th scope="col">ID</th>
                      <th scope="col">Customer</th>
                      <th scope="col">Mobile</th>
                      <th scope="col">Amount</th>
                      <th scope="col">Status</th>
                      <!-- <th scope="col">Product Count</th> -->
                      <th scope="col">Address</th>
                      <th scope="col">Date</th>
                    </tr>
                  </thead>
                  <tbody>
                  @forelse ($orderlist as $ol)
                    <tr>
                      <!-- <th scope="row">{{ $loop->iteration }}</th> -->
                      <td>{{$ol->order_id}}</td>
                      <td>{{$ol->first_name.' '.$ol->last_name}}</td>
                      <td>{{$ol->mobile_num}}</td>
                      <td>₹ {{number_format($ol->payment_amount,2)}}</td>
                      <td>{{ucwords($ol->payment_status)}}</td>
                      <!-- <td>{{$ol->product_count}}</td> -->
                      <td>{{$ol->delivery_address}}</td>
                      <td>{{date('Y-m-d h:i A',strtotime($ol->created_at))}}</td>
                    </tr>
                    @empty
                    <td colspan="5">
                      <span class="text-danger">
                        <strong>No Orders Found!</strong>
                      </span>
                    </td>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scripts')
<script src="{{ asset('backend/assets/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('backend/assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('backend/assets/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>
@endpush
@endsection
