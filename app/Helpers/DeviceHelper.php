<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class DeviceHelper
{
    public static function isMobile()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $mobileAgents = [
            'android', 'iphone', 'ipad', 'mobile', 'phone',
            'opera mini', 'blackberry', 'iemobile', 'kindle',
            'silk', 'symbian', 'webos', 'bada', 'windows phone'
        ];

        foreach ($mobileAgents as $agent) {
            if (stripos($userAgent, $agent) !== false) {
                return true;
            }
        }

        return false;
    }

    public static function isDesktop()
    {
        return !self::isMobile();
    }
    public static function generateHash($id)
    {
        $secretKey = config('app.key'); // Use the app key as the secret key
        $enckey = substr(hash_hmac('sha256', $id, $secretKey), 0, 15); // Limit to 15 characters
        $id .= config('app.id_seperator');
        return $id.$enckey;
    }
    public static function verifyHash($id, $hash)
    {
        $secretKey = config('app.key'); // Use the app key as the secret key
        // return hash_hmac('sha256', $id, $secretKey) === $hash;
        return substr(hash_hmac('sha256', $id, $secretKey), 0, 15) === $hash;
    }
    public static function calculategst($amount){
        $gstpercent = config('app.gst_percent');
        $original_amount =  $amount / (1 + ($gstpercent / 100));
        $gst_amount = $amount - $original_amount;
        return number_format($gst_amount,2);
        // $total_amount = $amount + $gst_amount;
        // return [
        //     'gst_amount' => number_format($gst_amount, 2, '.', ''),
        //     'total_amount' => number_format($total_amount, 2, '.', '')
        // ];
    } 
    public static function rndgen()
    {
        do {
            $num = sprintf('%06d', mt_rand(1000, 999999)); // Adjusted range to exclude numbers starting with 0
        } while (preg_match("~^0|(\d)\\1\\1\\1|(\d)\\2\\2\\2$~", $num)); // Updated regex to check if the number starts with 0
        return $num;
    }
    public static function sendOTP($phone, $otp)
    {
        // $post = [
        //     'key' => config('custom.custom.whatsapp_key'),
        //     'mobileno' => $phone,
        //     'msg'   => config('custom.custom.otp_template') . $otp,
        //     'type' => 'Text'
        // ];
        // $ch = curl_init('https://message.richsol.com/api/v1/sendmessage');
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        // $response = json_decode(curl_exec($ch));
        // curl_close($ch);
        // if ($response->status == 'Success') {
        //     return true;
        // } else {
        //     return false;
        // }
        return true;
    }
    public static function resendOTP(Request $request)
    {
        if (isset($request->phone) && is_numeric($request->phone) && strlen($request->phone) == 10) {
            $getUser = User::where('phone', $request->phone)->first();
            if ($getUser == null) {
                $getUser = DB::table('users')->insertGetId(['phone' => $request->phone, 'password' => Hash::make($request->phone)]);
            } else {
                Otp::where('user_id', $getUser->id)->delete();
                $getUser = $getUser->id;
            }
            $otp = $this->rndgen();
            if ($this->sendOTP($request->phone, $otp) == false) {
                return response()->json(['status' => 201, 'message' => 'Invalid Mobile Number'], 200);
            }
            Otp::firstOrNew(['otp' => $otp, 'user_id' => $getUser]);
            return response()->json(['status' => 200, 'message' => 'OTP send successfully', 'otp' => $otp], 200);
        } else {
            return response()->json(['status' => 202, 'message' => 'PLease provide valid Mobile Number'], 202);
        }
    }
    public function verifyOTP(Request $request)
    {
        if ((isset($request->phone) && is_numeric($request->phone) && strlen($request->phone) == 10) && (isset($request->otp_check) && is_numeric($request->otp_check) && strlen($request->otp_check) == 4)) {
            $getUser = User::where('phone', $request->phone)->first();
            if ($getUser != null) {
                $checkOTP = Otp::where('otp', $request->otp_check)->where('user_id', $getUser->id)->first();
                if ($checkOTP != null) {
                    Otp::where('otp', $request->otp_check)->where('user_id', $getUser->id)->delete();
                    return $this->jsonResponseGe('200', 'success', 'OTP Verified Successfully.');
                } else {
                    return $this->jsonResponseGe('201', 'failure', 'OTP is Invalid');
                }
            } else {
                return $this->jsonResponseGe('200', 'success', 'Mobile Number Not Registerd');
            }
        } else {
            return $this->jsonResponseGe('202', 'error', 'Please enter OTP received on Mobile Number');
        }
    }
}
