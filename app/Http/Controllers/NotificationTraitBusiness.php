<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


trait NotificationTraitBusiness
{

    public  function pushIosNotification($device_token, $title, $body, $payload)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $token = $device_token;
        $serverKey = 'AAAAB6BoOBE:APA91bGQQJfqOuj7CC8D0yc4yNhGkPZiIMP7TE485sLYFcKGwfpdKjaJ_VEHHqCalUz317AynwvoPc9dnZEVU9PRvO-H1vaGSqf1y7kAj2I_kSkkepX0zDOCYWtQ0F3dA2KwTIp4Cfuy';
        $notification = array('title' => $title, 'text' => $body, 'sound' => 'default', 'badge' => '1');
        $data = array(
            "to" => $token,
            "notification" => array(
                "title" => $title,
                "body" =>  $body,
                "sound" => "default"
            ),
            "mutable_content" => true,
            "data" => array("targetScreen" => "detail", 'notification' => $notification, 'payload' => $payload),
            "priority" => 10
        );
        $json = json_encode($data);
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key=' . $serverKey;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        //Send the request
        $response = curl_exec($ch);
        // Close request
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
    }

    public function storeNotification($device_token, $title, $body, $notify_type)
    {
        $sender_id = User::where('device_token', $device_token)->value('id');
        return $notification = DB::table('notifications')->insert(['sender_id' => $sender_id, 'notification_tittle' => $title, 'notification_message' => $body, 'notify_type' => $notify_type]);
    }



    public function notification($token, $title, $body, $payload = '', $push_type = 'list')
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $notification = [
            'title' => $title,
            "body" => $body,
            'sound' => true,
        ];
        $extraNotificationData = ["message" => $notification, "payload" => $payload, 'push_type' => $push_type];
        $fcmNotification = [
            //'registration_ids' => $tokenList, //multple token array
            'to'        => $token, //single token
            'notification' => $notification,
            'data' => $extraNotificationData
        ];
        $headers = [
            'Authorization: key=AAAAB6BoOBE:APA91bGQQJfqOuj7CC8D0yc4yNhGkPZiIMP7TE485sLYFcKGwfpdKjaJ_VEHHqCalUz317AynwvoPc9dnZEVU9PRvO-H1vaGSqf1y7kAj2I_kSkkepX0zDOCYWtQ0F3dA2KwTIp4Cfuy',
            'Content-Type: application/json'
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
        $response = curl_exec($ch);
        if ($response === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $response;
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
