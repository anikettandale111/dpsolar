<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DeviceHelper;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProductDetail;

class OrdersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth')->except('frontend', 'contact');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function Received()
    {
        return view('orders.received', [
            'orderlist' => Order::join('customers', 'customers.cust_id', '=', 'tbl_order.cust_id')
            ->whereIn('tbl_order.order_status',['Not Accepted'])
            ->select('customers.first_name','customers.last_name','customers.mobile_num', 'tbl_order.order_id', 'tbl_order.delivery_address', 'tbl_order.payment_type', 'tbl_order.product_count', 'tbl_order.payment_amount', 'tbl_order.oid', 'tbl_order.payment_status','tbl_order.created_at')
            ->orderBy('tbl_order.oid')->get()
        ]);
    }
    public function Inprogress()
    {
        return view('orders.accepted', [
            'orderlist' => Order::join('customers', 'customers.cust_id', '=', 'tbl_order.cust_id')
            ->whereIn('tbl_order.order_status',['Accepted'])
            ->select('customers.first_name','customers.last_name','customers.mobile_num', 'tbl_order.order_id', 'tbl_order.delivery_address', 'tbl_order.payment_type', 'tbl_order.product_count', 'tbl_order.payment_amount', 'tbl_order.oid', 'tbl_order.payment_status','tbl_order.created_at')
            ->orderBy('tbl_order.oid')->get()
        ]);
    }
    public function Delivered()
    {
        return view('orders.delivered', [
            'orderlist' => Order::join('customers', 'customers.cust_id', '=', 'tbl_order.cust_id')
            ->whereIn('tbl_order.order_status',['Delivered'])
            ->select('customers.first_name','customers.last_name','customers.mobile_num', 'tbl_order.order_id', 'tbl_order.delivery_address', 'tbl_order.payment_type', 'tbl_order.product_count', 'tbl_order.payment_amount', 'tbl_order.oid', 'tbl_order.payment_status','tbl_order.created_at')
            ->orderBy('tbl_order.oid')->get()
        ]);
    }
    public function Cancelled()
    {
        return view('orders.cancelled', [
            'orderlist' => Order::join('customers', 'customers.cust_id', '=', 'tbl_order.cust_id')
            ->whereIn('tbl_order.order_status',['Cancelled'])
            ->select('customers.first_name','customers.last_name','customers.mobile_num', 'tbl_order.order_id', 'tbl_order.delivery_address', 'tbl_order.payment_type', 'tbl_order.product_count', 'tbl_order.payment_amount', 'tbl_order.oid', 'tbl_order.payment_status','tbl_order.created_at')
            ->orderBy('tbl_order.oid')->get()
        ]);
    }
}
