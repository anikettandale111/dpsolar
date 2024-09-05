<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\DeviceHelper;
use App\Models\Customers;
use App\Models\Address;
use App\Models\Otp;
use DB;
use Auth;
use Hash;
use DataTables;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:customer')->except(['getotp', 'verifyotp']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getotp(Request $request)
    {
        if (isset($request->mobile_num) && is_numeric($request->mobile_num) && strlen($request->mobile_num) == 10) {
            $getUser = Customers::where('mobile_num', $request->mobile_num)->first();
            if ($getUser != null) {
                if ($getUser->is_delete == 0) {
                    $otp = DeviceHelper::rndgen();
                    if (DeviceHelper::sendOTP($request->mobile_num, $otp) == false) {
                        return response()->json(['status' => 201, 'message' => 'Invalid Mobile Number'], 200);
                    }
                    if (isset($getUser->cust_id) && $getUser->cust_id != '') {
                        Otp::where('user_id', $getUser->cust_id)->update(['otp' => $otp, 'mobile_number' => $request->mobile_num]);
                    }
                    return response()->json(['status' => 200, 'message' => 'OTP send successfully', 'otp' => $otp], 200);
                }
                return response()->json(['status' => 201, 'message' => 'Number Already Registerd With Us'], 200);
            } else {
                $otp = DeviceHelper::rndgen();
                $ids = DB::table('customers')->insertGetId(['first_name' => $request->first_name, 'last_name' => $request->last_name, 'mobile_num' => $request->mobile_num, 'is_delete' => 0, 'password' => Hash::make($request->mobile_num)]);
                if (DeviceHelper::sendOTP($request->mobile_num, $otp) == false) {
                    return response()->json(['status' => 201, 'message' => 'Invalid Mobile Number'], 200);
                }
                Otp::updateOrCreate(['user_id' => $ids], ['otp' => $otp, 'mobile_number' => $request->mobile_num]);
                return response()->json(['status' => 200, 'message' => 'OTP send successfully', 'otp' => $otp], 200);
            }
        } else {
            return $this->jsonResponseGe('202', 'error', 'Please provide valid Mobile Number');
        }
    }

    public function verifyotp(Request $request)
    {
        if ((isset($request->mobile_num) && is_numeric($request->mobile_num) && strlen($request->mobile_num) == 10) &&
            (isset($request->mobile_otp) && is_numeric($request->mobile_otp) && strlen($request->mobile_otp) == 6)
        ) {
            $getUser = Customers::where('mobile_num', $request->mobile_num)->first();
            $getOtpUser = Otp::where(['mobile_number' => $request->mobile_num, 'otp' => $request->mobile_otp])->first();
            if ($getUser != null && $getOtpUser != null) {
                return response()->json(['status' => 200, 'message' => 'OTP verified successfully'], 200);
            } else {
                return response()->json(['status' => 201, 'message' => 'OTP verified failed'], 201);
            }
        }
        return response()->json(['status' => 201, 'message' => 'OTP verified failed'], 201);
    }

    public function dashboard(Request $request)
    {
        return view('customer.index');
    }
    public function addressadd(Request $request) {
        $request['cust_id'] = Auth::guard('customer')->user()->cust_id; 
        $request['city'] = $request->address_city; 
        $request['state'] = $request->address_state; 
        $request['pincode'] = $request->address_pincode; 
        unset($request['address_city']);
        unset($request['address_state']);
        unset($request['address_pincode']);
        $data['address_one'] = $request->address_one;
        $data['address_two'] = $request->address_two;
        $data['address_three'] = $request->address_three;
        $data['cust_id'] = $request->cust_id;
        $data['city'] = $request->city;
        $data['state'] = $request->state;
        $data['pincode'] = $request->pincode;
        $data['is_primary'] = (isset($request->is_primary)) ? $request->is_primary : 0; 
        if(isset($request->aid) && $request->aid != ''){
            $a_id = explode(config('app.id_seperator'), $request->aid)[0];
            $a_id = Address::where('aid',$a_id)->update($data);
            $msg = 'Address Updated Succesfully';
        }else{
            $a_id = Address::insertGetId($data);
            $msg = 'Address Added Succesfully';
        }
        if(isset($a_id) && $a_id > 0){
            return response()->json(['status' => 200, 'message' => $msg], 201);
        }
        return response()->json(['status' => 200, 'message' => 'Sorry, Please try again.'], 201);
    }
    public function addressget($id){
        $a_id = explode(config('app.id_seperator'), $id)[0];
        $add = Address::where('aid',$a_id)->first();
        return response()->json($add, 200);
    }
    public function addressdelete($id){
        $a_id = explode(config('app.id_seperator'), $id)[0];
        Address::where('aid',$a_id)->update(['is_delete'=>1]);
        return response()->json(['status' => 200, 'message' => 'Address Deleted Succesfully.'], 200);
    }
    public function addresslist(Request $request){
        if($request->ajax()){
            $address = Address::where(['cust_id'=> Auth::guard('customer')->user()->cust_id, 'is_delete'=>0])->get();
            return datatables()->of($address)
            ->addIndexColumn()
            ->addColumn('addressstr', function ($row) {
                return $row->address_one.' '.$row->address_two.' '.$row->address_three.' '.$row->city.' '.$row->state.' '.$row->pincode;
            })
            ->addColumn('action', function ($row) {
                $hashedId = DeviceHelper::generateHash($row->aid);
                $btn = '<button type="button" class="btn btn-primary addressedit" data-toggle="modal" data-target="#exampleModalCenter" onclick="editRecord(\'' . $hashedId . '\')">Edit</button>';
                $btn .= ' <button type="button" class="btn btn-danger addressdelete" onclick="deleteRecord(\'' . $hashedId . '\')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action','addressstr'])
            ->make(true);
          }
    }
    public function address(Request $request){
        return view('customer.address_model');
    }
}
