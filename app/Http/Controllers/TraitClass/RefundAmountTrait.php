<?php

namespace App\Http\Controllers\TraitClass;

use App\Http\Controllers\Paytm\PaytmChecksum;

trait RefundAmountTrait
{

    private function refundAmount($transaction_id, $order_id, $amount)
    {
        $paytmParams = array();
        $paytm_merchant_key          = 'Pd6#E%n7wYFH3yXr';
        $paytmParams["body"] = array(
            "mid"          => "STjkXC18094287248734",
            "txnType"      => "REFUND",
            "orderId"      => $order_id,
            "txnId"        => $transaction_id,
            "refId"        => "REFUNDID_" . $order_id,
            "refundAmount" => number_format($amount, 2, '.', ''),
        );
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $paytm_merchant_key);
        $paytmParams["head"] = array(
            "signature"      => $checksum
        );
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);
        $url = "https://securegw.paytm.in/refund/apply";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        return curl_exec($ch);
    }
}
