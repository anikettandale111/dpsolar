<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderProductDetail;
use App\Helpers\DeviceHelper;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;
use Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:customer')->except(['index', 'addToCart', 'cartCount', 'totalcal']);
    }

    public function index()
    {
        $product = Session::get('cart', []);
        if (isset(Auth::guard('customer')->user()->cust_id) && Auth::guard('customer')->user()->cust_id > 0) {
            $address = Address::where(['cust_id' => Auth::guard('customer')->user()->cust_id, 'is_delete' => 0])->get();
            return view('cart.index', compact('product', 'address'));
        } else {
            return view('cart.index', compact('product'));
        }
    }

    public function cartCount()
    {
        $cart = Session::get('cart', []);
        return json_encode(['cartcount' => count($cart)]);
    }

    public function addToCart(Request $request)
    {
        // Session::forget('cart');
        $p_id = explode(config('app.id_seperator'), $request->product)[0];
        $pr_detail = Product::findOrFail($p_id);
        if (Session::has('cart') && !empty(Session::get('cart'))) {
            $cart = Session::get('cart', []);
        } else {
            $cart = [];
        }
        $quantity = $request->productqty;
        $order_number = config('app.short_name') . '-' . date('Ymdhis');
        if (Session::has('cart') && !empty(Session::get('cart'))) {
        } else {
            Session::put('order_number', $order_number);
        }
        if (isset($cart[$p_id])) {
            // If the product already exists in the cart, update the quantity
            $cart[$p_id]['quantity'] += $quantity;
            $msg = 'Product quantity updated!';
        } else {
            $images = json_decode($pr_detail->images);
            // Add the product to the cart
            $cart[$p_id] = [
                'prod_id' => $p_id,
                'quantity' => $quantity,
                'prod_name' => $pr_detail->product_name,
                'description' => $pr_detail->description,
                'sel_price' => $pr_detail->selling_price, // Assuming price is passed in the request
                'disp_price' => $pr_detail->display_price, // Assuming price is passed in the request
                'name' => $pr_detail->product_name, // Assuming name is passed in the request
                'image' => $images[0] // Assuming name is passed in the request
            ];
            $msg = 'Product added to cart!';
        }
        Session::put('cart', $cart);
        $cart = Session::get('cart', []);
        return json_encode(['status' => 'success', 'message' => $msg, 'cartcount' => count($cart)]);
    }

    public function totalcal(Request $request)
    {
        if (Session::has('cart') && !empty(Session::get('cart'))) {
            $cart = Session::get('cart', []);
        }
        $netamount = 0;
        $gstamount = 0;
        $shippingamt = config('app.shipment_charge');
        $totalamt = 0;
        if (isset($request->hashid) && $request->hashid != '' && isset($request->newqty) && $request->newqty != '') {
            $p_id = explode(config('app.id_seperator'), $request->hashid)[0];
            $pr_detail = Product::findOrFail($p_id);
            $quantity = $request->newqty;
            if (isset($cart[$p_id])) {
                $cart[$p_id]['quantity'] = $quantity;
            }
            Session::put('cart', $cart);
        }
        if (isset($cart) && count($cart)) {
            foreach ($cart as $key => $c) {
                $netamount += $c['quantity'] * $c['sel_price'];
            }
            $totalamt = $netamount + $shippingamt;
            $gstamount = DeviceHelper::calculategst($totalamt);
            $netamount = $netamount - $gstamount;
        }
        if (Session::has('cart_total') && !empty(Session::get('cart_total'))) {
            $cart_total = Session::get('cart_total', []);
        } else {
            $cart_total = [];
        }
        $cart_total = ['netamount' => number_format($netamount, 2), 'gstamount' => number_format($gstamount, 2), 'shippingamt' => number_format($shippingamt, 2), 'totalamt' => number_format($totalamt, 2)];
        Session::put('cart_total', $cart_total);
        return json_encode($cart_total);
    }
    public function checkout(Request $request)
    {
        $cart = [];
        $cart_total = [];
        if (Session::has('cart') && !empty(Session::get('cart'))) {
            $cart = Session::get('cart');
        }
        if (Session::has('cart_total') && !empty(Session::get('cart_total'))) {
            $cart_total = Session::get('cart_total');
        }
        $session_order_number = Session::get('order_number', []);
        $customer_name = Auth::guard('customer')->user()->first_name . ' ' . Auth::guard('customer')->user()->last_name;
        $a_id = explode(config('app.id_seperator'), $request->delivery_address)[0];
        $address = Address::where(['cust_id' => Auth::guard('customer')->user()->cust_id, 'aid' => $a_id])->selectRaw('GROUP_CONCAT(address_one, ", ", address_two, ", ", address_three, ", ", city, ", ", state, ", ", pincode) as address')->first()->address;
        $data['order_id'] = $session_order_number;
        $data['cust_id'] = Auth::guard('customer')->user()->cust_id;
        $data['product_count'] = count($cart);
        $data['payment_amount'] = str_replace(',', '', $cart_total['totalamt']);
        $data['delivery_address'] = str_replace(',', ' ', $address);
        $data['shipping_charge'] = str_replace(',', '', $cart_total['shippingamt']);
        $data['cgst'] = str_replace(',', '', round(($cart_total['gstamount'] / 2), 2));
        $data['sgst'] = str_replace(',', '', round(($cart_total['gstamount'] / 2), 2));
        $data['discount'] = '0';
        $data['payment_type'] = $request->payment_method;
        $data['payment_status'] = 'Unpaid';
        $data['order_status'] = 'Not Accepted';
        $data['remark'] = 'NA';

        $fieldsToUpdate = [];
        $conditions = ['order_id' => $session_order_number, 'cust_id' => Auth::guard('customer')->user()->cust_id];
        $existingRecord = Order::where($conditions)->first();
        $oldAttributes = $existingRecord ? $existingRecord->getAttributes() : null;
        $o_status = 0;
        if ($existingRecord) {
            foreach ($data as $key => $value) {
                if (isset($oldAttributes[$key]) && $oldAttributes[$key] != $value) {
                    $fieldsToUpdate[$key] = $value;
                }
            }
            if (isset($fieldsToUpdate) && count($fieldsToUpdate)) {
                $record = Order::updateOrCreate($conditions, $fieldsToUpdate);
                if (isset($fieldsToUpdate['payment_amount']) && !empty($fieldsToUpdate['payment_amount'])) {
                    $o_status = 1;
                }
                $newAttributes = $record->getAttributes();
            }
        } else {
            $o_status = 1;
            $record = Order::updateOrCreate($conditions, $data);
            $newAttributes = $record->getAttributes();
        }
        if (isset($request->payment_method) && $request->payment_method == 'UPI') {
            $razor_key_id = config('custom.custom.RAZOR_KEY');
            $razor_key_secret = config('custom.custom.RAZOR_SECRET');
            $value = str_replace([',', '.'], '', $cart_total['totalamt']);
            $totalamt = floatval($value);
            $api = new Api($razor_key_id, $razor_key_secret);
            $razordata = ['receipt' => $session_order_number, 'amount' => intval($totalamt), 'currency' => 'INR', 'payment_capture' => 1, 'notes' => ['customer_name' => $customer_name, 'phone' => Auth::guard('customer')->user()->mobile_num, 'note' => 'First Order Test']];
            if ($o_status == 1) {
                $res = $api->order->create($razordata);
                $razor_order_id = $res->id;
                Order::where(['order_id' => $session_order_number])->update(['razor_order_id' => $razor_order_id]);
            } else {
                $razor_order_id = Order::where(['order_id' => $session_order_number])->first()->razor_order_id;
            }
            return view('cart.razor', compact('totalamt', 'razor_key_id', 'razor_order_id'));
        } else {
            session()->forget('cart');
            session()->forget('order_number');
            session()->forget('cart_total');
            $message = ['status' => 'success', 'message' => 'Order Placed successfully. We will deliver your order within 48hrs.'];
            return view('cart.checkout', compact('message'));
        }
    }
    public function deleteitem($hashid)
    {
        $p_id = explode(config('app.id_seperator'), $hashid)[0];
        if (Session::has('cart') && !empty(Session::get('cart'))) {
            $cart = Session::get('cart');
            unset($cart[$p_id]);
            $cart = Session::put('cart', $cart);
        }
        return json_encode(['status' => 'success', 'message' => 'Product Removed from Cart']);
    }
    public function orderComplete(Request $request)
    {
        $message = ['status' => 'success', 'message' => 'Order Placed successfully.'];
        $order = Order::where('cust_id', Auth::guard('customer')->user()->cust_id)->orderBy('oid','DESC')->first();
        $orderProduct = OrderProductDetail::where('order_number', $order->order_id)->get();
        return view('cart.invoice', compact('message','order','orderProduct'));
    }
    public function payment(Request $request)
    {
        if (isset($request->payment_response) && $request->payment_response != NULL) {
            $response  = json_decode($request->payment_response);
            if (isset($response->razorpay_payment_id) && $response->razorpay_payment_id != NULL) {
                $request['razorpay_payment_id'] = $response->razorpay_payment_id;
            }
        }
        $payment_detalis = null;
        $api = new Api(config('custom.custom.RAZOR_KEY'), config('custom.custom.RAZOR_SECRET'));
        $payment = $api->payment->fetch($request->razorpay_payment_id);
        if ($payment->status == 'captured') {
            $payment_detalis = json_encode(array('id' => $payment->id, 'method' => $payment->method, 'amount' => $payment->amount, 'currency' => $payment->currency));
        }
        if (isset($request->razorpay_payment_id)  && !empty($request->razorpay_payment_id)) {
            if ($payment_detalis == null) {
                try {
                    $response = $api->payment->fetch($request->razorpay_payment_id)->capture(array('amount' => $payment['amount']));
                    $payment_detalis = json_encode(array('id' => $response['id'], 'method' => $response['method'], 'amount' => $response['amount'], 'currency' => $response['currency']));
                } catch (\Exception $e) {
                    \Session::put('error', $e->getMessage());
                    return redirect()->back();
                }
            }
        }
        return $this->checkout_done(Session::get('order_number', []), $payment_detalis, 'razor');
    }
    public function checkout_done($order_id, $paymentDetails = '', $paymentMethod)
    {
        $order = Order::where('order_id', $order_id)->first();
        if ($paymentMethod == 'cod') {
            $order->payment_status = 'unpaid';
        } else {
            $order->payment_status = 'paid';
        }
        $order->payment_method = $paymentMethod;
        $order->payment_details = $paymentDetails;
        $status = $order->save();
        if (Session::has('cart') && !empty(Session::get('cart'))) {
            $cart = Session::get('cart');
        }
        $cartorderprod = [];
        foreach ($cart as $key => $ct) {
            $gst = DeviceHelper::calculategst($ct['sel_price']);
            $conditions = ['order_number' => Session::get('order_number', []), 'prod_id' => $ct['prod_id']];
            $cartorderprod = ['prod_name' => $ct['prod_name'], 'quantity' => $ct['quantity'], 'price' => $ct['sel_price'], 'sgst' => str_replace(',', '', round(($gst / 2), 2)), 'cgst' => str_replace(',', '', round(($gst / 2), 2)), 'discount' => ($ct['disp_price'] - $ct['sel_price']), 'total_price' => ($ct['quantity'] * $ct['sel_price']), 'image' => $ct['image']];
            OrderProductDetail::updateOrCreate($conditions, $cartorderprod);
        }

        if ($status) {
            $array['view'] = 'mail.invoice';
            $array['subject'] = 'Your order has been placed -' . $order['order_number'];
            $array['from'] = env('MAIL_FROM_ADDRESS', 'info@machiwala.co.in');
            $array['admin_subject'] = 'You have new order from -' . $order['order_number'];
            $array['order'] = $order;

            if (env('MAIL_USERNAME')) {
                try {
                    Mail::to($order['email'])->send(new OrderMail($array));
                    Mail::to(Admin::first()->email)->send(new OrderMailAdmin($array));
                } catch (\Exception $e) {
                    return back()->with('error', $e->getMessage());
                }
            }
            session()->forget('cart');
            session()->forget('order_number');
            session()->forget('cart_total');
            return redirect()->route('cart.complete')->with('success', 'Your order has been placed successfully');
        } else {
            return back()->with('error', 'Something went wrong!, please try again.');
        }
    }
}
