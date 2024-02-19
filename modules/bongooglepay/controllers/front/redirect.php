<?php
/**
 * 2015-2021 Bonpresta
 *
 * Bonpresta Google Pay
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2021 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
*/
include(dirname(__FILE__).'/../../../../config/config.inc.php');
require_once('../../../../init.php');
require_once(dirname(__FILE__) . '../../../bongooglepay.php');
 
$cont = new FrontController();
$cont->init();
$context = Context::getContext();
       
$module = new Bongooglepay();
$private_key =  Configuration::get('BON_PROVIDER_SECRET');
$public_key =  Configuration::get('BON_PROVIDER_ID');
$payment_provider =  Configuration::get('BON_PAYMENT_PROVIDER');
$post_url = '';

$get_data = Tools::file_get_contents('php://input');
$data = json_decode($get_data);

$pageName = $data->pageName;
$googleToken = $data->gpay_token;
$description = $data->paymentDescription;
 
$order_id = '';

$ch = curl_init();

if ($pageName == 'product') {
    $product = $module -> infoOnProductPage();
    $product_name = $product[1];
    $product_url = $product[0];
    $totalPrice = $data->totalPrice;
    $currency = $data->currency;
    $payerEmail = $data->payerEmail;
    $first_name = $data->payerName;
    $last_name = $data->payerName;
    $phoneNumber = $data->phoneNumber;
    $senderCity = $data->senderCity;
    $senderPostalCode = $data->senderPostalCode;
    $senderAddress = $data->shippingAddress;
    $result_url = '';
    $bytes = random_bytes(9);
    $order_id = bin2hex($bytes);
} elseif ($pageName == 'checkout') {
    $payment_data = $module -> googlePayContent();
    $cart_id = $payment_data['id_cart'];
    $totalPrice = $payment_data['total'];
    $currency = $payment_data['currency'];
    $payerEmail = $payment_data['payer_email'];
    $first_name = $payment_data['firstname'];
    $last_name = $payment_data['lastname'];
    $phoneNumber = $payment_data['phone'];
    $senderCity = $payment_data['sender_city'];
    $senderAddress = $payment_data['sender_address'];
    $senderPostalCode = $payment_data['sender_postcode'];
    $product_name = $payment_data['name'];
    $result_url = 'http://'.htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8').__PS_BASE_URI__.'index.php?controller=history';
    $order_id = $cart_id;
}

if ($payment_provider == 'adyen') {
    $post_url = 'https://checkout-test.adyen.com/v66/payments';
    $post_fields = [
        'amount' => [
          'currency' => $currency,
          'value' => (float)$totalPrice*100
        ],
        'reference' => $order_id,
        'paymentMethod' => [
          'type' => 'paywithgoogle',
          'googlePayToken' => $googleToken
        ],
        'merchantAccount' => $public_key,
        'returnUrl'=> __PS_BASE_URI__,
    ];
    $fields_string = json_encode($post_fields);
    $headers = array();
    $headers[] = 'Content-type: application/json';
    $headers[] = 'x-API-key: ' . $private_key;
}

if ($payment_provider == 'checkoutltd') {
    $get_token_url = 'https://api.checkout.com/tokens';
    $get_token_data = [
        'type' => 'googlepay',
        'token_data' => $googleToken
    ];

    $get_token_string = json_encode($get_token_data);
    $headers_token = array();
    $headers_token[] = 'Content-type: application/json';
    $headers_token[] = 'Authorization: ' . $public_key;


    curl_setopt($ch, CURLOPT_URL, $get_token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers_token);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $get_token_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $get_token_result = curl_exec($ch);
    $checkoutltd_result = json_decode($get_token_result);
    $checkoutltd_token = $checkoutltd_result->token;
        
    $post_url = 'https://api.checkout.com/payments';
    $post_fields = [
        "source" => [
          "type" => "token",
          "token" => $checkoutltd_token
        ],
        "amount" => (float)$totalPrice*100,
        "currency" => $currency,
        "reference" => $order_id,
    ];
    
    $fields_string = json_encode($post_fields);
    
    $headers = array();
    $headers[] = 'Content-type: application/json';
    $headers[] = 'Authorization: ' . $private_key;
}

curl_setopt($ch, CURLOPT_URL, $post_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
$result = curl_exec($ch);
$parsed_result = json_decode($result);

if ($payment_provider == 'adyen') {
    $result_status = $parsed_result->resultCode;
}
 
if ($result_status == 'success' || $result_status == 'sender_verify' || $result_status == 'Authorised' || $result_status == 'Authorized') {
    if ($pageName == 'product') {
        die(json_encode(array('success' => 1, 'product_name' => $product,  'alert' => $module->successAlert, 'alertDescription' => $module->successDescription, 'payment_provider' => $payment_provider, 'result'=>$result)));
    } elseif ($pageName == 'checkout') {
        $module->validateOrder($cart_id, Configuration::get('PS_OS_PREPARATION'), $totalPrice, $module->displayName);
        $order_id = Order::getOrderByCartId((int)($cart_id));
        $order = new Order($order_id);
        $customer = new CustomerCore($order->id_customer);
        $module = Module::getInstanceByName($order->module);
        $redirect_url = 'order-confirmation?id_cart=' . $cart_id . '&id_module=' . $module->id . '&id_order=' .$order_id . '&key='.$customer->secure_key;
        die(json_encode(array('result'=>$result, 'product_name' => $product_name, 'redirect_url' => $redirect_url)));
    }
} else {
    if ($pageName == 'product') {
        die(json_encode(array('success' => 2, 'error' => $module->errorAlert, 'result'=>
        $get_token_result)));
    } elseif ($pageName == 'checkout') {
        return false;
    }
}
