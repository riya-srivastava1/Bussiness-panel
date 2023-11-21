<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait NotificationTrait
{
    public  function pushIosNotification($device_token, $title, $body, $notify_type)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=AIzaSyB7qrTTgyMTfgnpJuQI-tKc5QSOJxJFRnc';
        $arrayToSend = array(
            'to' => $device_token,
            'notification' => $notification,
            'priority' => 'high',
            'data' => ['notification_type' => "title"]
        );
        $json = json_encode($arrayToSend);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        if ($response === false) {
            return 0;
        } else {
            $this->storeNotification($device_token, $title, $body, $notify_type);
            return 1;
        }
    }

    public function storeNotification($device_token, $title, $body, $notify_type)
    {
        $sender_id = User::where('device_token', $device_token)->value('id');
        return $notification = DB::table('notifications')->insert(['sender_id' => $sender_id, 'notification_tittle' => $title, 'notification_message' => $body, 'notify_type' => $notify_type]);
    }

    public function pushAndroidNotification($device_token, $title, $body, $notify_type)
    {
        $array = array(
            "to" => $device_token,
            "content_available" => true,
            "data" => array(
                "title" => $title,
                "Body" => $body,
                "noti_type" => 1,
            )
        );
        $arrayToSend = json_encode($array);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $arrayToSend,
            CURLOPT_HTTPHEADER => array(
                "authorization: key=AIzaSyB7qrTTgyMTfgnpJuQI-tKc5QSOJxJFRnc",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        if (curl_error($curl)) {
            echo 'error:' . curl_error($curl);
            exit();
        }
        $json = json_decode($response, true);
        if ($json['success']) {
            $status = 1;
        }
        curl_close($curl);
        if ($json['success']) {
            // $this->storeNotification($device_token,$title,$body,$notify_type);
            return 1;
        } else {
            return 0;
        }
    }

    public function notification($token, $title, $body, $payload = [])
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $token = $token;
        $notification = [
            'title' => $title,
            "body" => $body,
            'sound' => true,
        ];
        $extraNotificationData = ["message" => $notification, 'payload' => $payload];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];

        $headers = [
            'Authorization: key=AIzaSyB7qrTTgyMTfgnpJuQI-tKc5QSOJxJFRnc',
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $result = curl_exec($ch);
        curl_close($ch);

        return "true";
    }

    public function signup(Request $request)
    {
        if (User::where('SocialId', '=', $request->SocialId)->where('login_type', '=', $request->SocialType)->exists()) {
            $data = [
                'fullname' => $request->name,
                'profile_image' => $request->profile_image,
                'access_token' => Str::random(60),
                'device_type' => $request->device_type,
                'device_token' => $request->device_token,
                'is_register' => 1
            ];
            $id = User::where('SocialId', '=', $request->SocialId)->where('login_type', '=', $request->SocialType)->update($data);
            $user_data = User::where('SocialId', '=', $request->SocialId)->where('login_type', '=', $request->SocialType)->select('fullname', 'email', 'SocialId', 'login_type', 'profile_image', 'access_token', 'is_profile_created', 'id')->first();
            if (empty($user_data->profile_image)) {
                $user_data->profile_image = url('public/images') . '/' . '0180441436.jpg';;
            }
            return response()->json(['data' => $user_data, 'message' => __('messages.success.login')], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            $save = new User;
            $save->fullname = $request->name;
            $save->email = $request->email;
            $save->is_register = 1;
            $save->profile_image = $request->profile_image;
            $save->SocialId = $request->SocialId;
            $save->device_token = $request->device_token;
            $save->device_type = $request->device_type;
            $save->login_type = $request->SocialType;
            $save->access_token = Str::random(60);
            $save->save();
            if (empty($save->profile_image)) {
                $save->profile_image = url('public/images') . '/' . '0180441436.jpg';
            }
            return response()->json(['data' => $save, 'message' => __('messages.success.login')], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
}
