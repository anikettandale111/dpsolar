@extends('frontend.front')
@php
$prodtot=0.00;
$grandtot=0.00;
@endphp
@section('title', 'Cart Detail')
@section('content')
<div class="best_sellers mt-5">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <div class="section_title new_arrivals_title">
                    <h2 class="mb-0">My Orders</h2>
                    <hr>
                </div>
            </div>
        </div>
        <div class="container rounded cart">
            <div class="row no-gutters">
                <div class="col-md-12">
                    <div class="product-details">
                        <table id="example" class="table table-striped nowrap" style="width:100%;margin-top:45px;">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade bd-example-modal-lg" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Address</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="address">
                            @csrf
                            <div class="row col-12">
                                <div class="form-group col-6">
                                    <label for="address_one" class="col-form-label">House/Flat Number:</label>
                                    <input type="text" name="address_one" class="form-control" autocomplete="off" required id="address_one">
                                    <span class="address_one error"></span>
                                </div>
                                <div class="form-group col-6">
                                    <label for="address_two" class="col-form-label">Street:</label>
                                    <input type="text" name="address_two" class="form-control" autocomplete="off" required id="address_two">
                                    <span class="address_two error"></span>
                                </div>
                            </div>
                            <div class="row col-12">
                                <div class="form-group col-6">
                                    <label for="address_three" class="col-form-label">Landmark:</label>
                                    <input type="text" name="address_three" class="form-control" autocomplete="off" required id="address_three">
                                    <span class="address_three error"></span>
                                </div>
                                <div class="form-group col-6">
                                    <label for="address_state" class="col-form-label">State:</label>
                                    <input type="text" name="address_state" class="form-control" autocomplete="off" required id="address_state">
                                    <span class="address_state error"></span>
                                </div>
                            </div>
                            <div class="row col-12">
                                <div class="form-group col-6">
                                    <label for="address_city" class="col-form-label">City:</label>
                                    <input type="text" name="address_city" class="form-control" autocomplete="off" required id="address_city">
                                    <span class="address_city error"></span>
                                </div>
                                <div class="form-group col-6">
                                    <label for="address_pincode" class="col-form-label">Pincode:</label>
                                    <input type="text" name="address_pincode" class="form-control" autocomplete="off" required id="address_pincode" maxlength="6">
                                    <span class="address_pincode error"></span>
                                </div>
                            </div>
                            <input type="hidden" id="aid" name="aid" value="">
                            <div class="row col-12">
                                <div class="form-group col-12">
                                    <label for="is_primary" class="col-form-label">Primary:</label>
                                    <input type="checkbox" id="is_primary" name="is_primary" value="1">
                                </div>
                            </div>
                            <div class="row col-12">
                                <div class="form-group col-6">
                                    <button type="button" class="btn btn-secondary pull-right" data-dismiss="modal">Close</button>
                                </div>
                                <div class="form-group col-6">
                                    <button type="button" id="address_submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    var APP_URL = $('#app-url').attr("content");
    $(document).ready(function() {
        var categoryTable;
        categoryTable = $('#example').DataTable({
            processing: true,
            serverSide: true,
            responsive:true,
            scrollX: true,
            // bPaginate: false,
            bLengthChange: false,
            searching: false,
            // bFilter: true,
            // bInfo: false,
            // bAutoWidth: false,
            ajax: APP_URL + "/customer/orders",
            columns: [
                // {
                //     data: 'DT_RowIndex',
                //     name: 'DT_RowIndex'
                // },
                {
                    data: 'order_id',
                    name: 'Order ID'
                },
                {
                    data: 'orderdate',
                    name: 'Date'
                },
                {
                    data: 'orderstatus',
                    name: 'Status'
                },
                {
                    data: 'action',
                    name: 'Action'
                }
            ]
        });
    });
</script>
@endpush