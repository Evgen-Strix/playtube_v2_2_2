<?php

if (IS_LOGGED == false && $first != 'success_fortumo' && $first != 'success_aamarpay') {
    $data = array(
        'status' => 400,
        'error' => 'Not logged in'
    );
    echo json_encode($data);
    exit();
}


use PayPal\Api\Payer;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\InputFields;
use PayPal\Api\WebProfile;


$payment_currency = $pt->config->payment_currency;
$paypal_currency = $pt->config->paypal_currency;
$payer        = new Payer();
$item         = new Item();
$itemList     = new ItemList();
$details      = new Details();
$amount       = new Amount();
$transaction  = new Transaction();
$redirectUrls = new RedirectUrls();
$payment      = new Payment();
$payer->setPaymentMethod('paypal');

if ($first == 'replenish') {
	$data    = array('status' => 400);
	$request = (!empty($_POST['amount']) && is_numeric($_POST['amount']));
	if ($request === true) {
		$inputFields = new InputFields();
	    $inputFields->setAllowNote(true)
	        ->setNoShipping(1)
	        ->setAddressOverride(0);
	    $webProfile = new WebProfile();
	    $webProfile->setName("Pay to view video" . uniqid())
	        ->setInputFields($inputFields);
	    try {
	        $createdProfile = $webProfile->create($paypal);
	        $createdProfileID = json_decode($createdProfile);
	        $profileid = $createdProfileID->id;
	    } catch(PayPal\Exception\PayPalConnectionException $pce) {
	    	$data = array(
	            'type' => 'ERROR',
	            'details' => json_decode($pce->getData())
	        );
	    }
		$rep_amount  = $_POST['amount'];
		$redirectUrl = PT_Link("aj/wallet/get_paid?status=success&amount=$rep_amount");
		$redirectUrls->setReturnUrl($redirectUrl)->setCancelUrl(PT_Link(''));    
	    $item->setName('Replenish your balance')->setQuantity(1)->setPrice($rep_amount)->setCurrency($paypal_currency);  
	    $itemList->setItems(array($item));    
	    $details->setSubtotal($rep_amount);
	    $amount->setCurrency($paypal_currency)->setTotal($rep_amount)->setDetails($details);
	    $transaction->setAmount($amount)->setItemList($itemList)->setDescription('Replenish your balance')->setInvoiceNumber(time());
	    $payment->setExperienceProfileId($profileid)->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions(array(
	        $transaction
	    ));

	    try {
	        $payment->create($paypal);
	    }

	    catch (Exception $e) {
	        $data = array(
	            'type' => 'ERROR',
	            'details' => json_decode($e->getData())
	        );

	        if (empty($data['details'])) {
	            $data['details'] = json_decode($e->getCode());
	        }
	        echo json_encode($data);
	    	exit();
	    }

	    $data = array(
	        'status' => 200,
	        'type' => 'SUCCESS',
	        'url' => $payment->getApprovalLink()
	    );

	}
}

if ($first == 'get_paid') {
	$data['status'] = 500;
	$request        = (
		!empty($_GET['paymentId']) && 
		!empty($_GET['PayerID']) && 
		!empty($_GET['status']) && 
		!empty($_GET['amount']) && 
		is_numeric($_GET['amount']) && 
		$_GET['status'] == 'success'
	);

	if ($request === true) {

		$paymentId = PT_Secure($_GET['paymentId']);
		$PayerID   = PT_Secure($_GET['PayerID']);
		$payment   = Payment::get($paymentId, $paypal);
	    $execute   = new PaymentExecution();
	    $execute->setPayerId($PayerID);

	    try{
	        $result = $payment->execute($execute, $paypal);
	    }

	    catch (Exception $e) {
	        $data = array(
	            'type' => 'ERROR',
	            'details' => json_decode($e->getData())
	        );

	        if (empty($data['details'])) {
	            $data['details'] = json_decode($e->getCode());
	        }

	        echo json_encode($data);
	    	exit();
	    }

		$amount  = $_GET['amount'];
		$update  = array('wallet' => ($user->wallet += $amount));
		$db->where('id',$user->id)->update(T_USERS,$update);
		$payment_data         = array(
    		'user_id' => $user->id,
    		'paid_id'  => $user->id,
    		'admin_com'    => 0,
    		'currency'    => $pt->config->paypal_currency,
    		'time'  => time(),
    		'amount' => $amount,
    		'type' => 'ad'
    	);
		$db->insert(T_VIDEOS_TRSNS,$payment_data);


		$_SESSION['upgraded'] = true;
		$url     = PT_Link('wallet');
		if (!empty($_COOKIE['redirect_page'])) {
            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
        }
    	header("Location: $url");
    	exit();

	}
}

if ($first == 'checkout_replenish' && $pt->config->checkout_payment == 'yes') {
	if (empty($_POST['card_number']) || empty($_POST['card_cvc']) || empty($_POST['card_month']) || empty($_POST['card_year']) || empty($_POST['token']) || empty($_POST['card_name']) || empty($_POST['card_address']) || empty($_POST['card_city']) || empty($_POST['card_state']) || empty($_POST['card_zip']) || empty($_POST['card_country']) || empty($_POST['card_email']) || empty($_POST['card_phone'])) {
        $data = array(
            'status' => 400,
            'error' => $lang->please_check_details
        );
    }
    else {
		if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
			require_once 'assets/import/2checkout/Twocheckout.php';
		    Twocheckout::privateKey($pt->config->checkout_private_key);
		    Twocheckout::sellerId($pt->config->checkout_seller_id);
		    if ($pt->config->checkout_mode == 'sandbox') {
		        Twocheckout::sandbox(true);
		    } else {
		        Twocheckout::sandbox(false);
		    }
		    try {
		    	$amount = PT_Secure($_POST['amount']);


		    	$charge  = Twocheckout_Charge::auth(array(
		            "merchantOrderId" => "123",
		            "token" => $_POST['token'],
		            "currency" => $pt->config->checkout_currency,
		            "total" => $amount,
		            "billingAddr" => array(
		                "name" => $_POST['card_name'],
		                "addrLine1" => $_POST['card_address'],
		                "city" => $_POST['card_city'],
		                "state" => $_POST['card_state'],
		                "zipCode" => $_POST['card_zip'],
		                "country" => $countries_name[$_POST['card_country']],
		                "email" => $_POST['card_email'],
		                "phoneNumber" => $_POST['card_phone']
		            )
		        ));
		        if ($charge['response']['responseCode'] == 'APPROVED') {

					$update  = array('wallet' => ($user->wallet += $amount));
					$db->where('id',$user->id)->update(T_USERS,$update);
					$payment_data         = array(
			    		'user_id' => $user->id,
			    		'paid_id'  => $user->id,
			    		'admin_com'    => 0,
			    		'currency'    => $pt->config->checkout_currency,
			    		'time'  => time(),
			    		'amount' => $amount,
			    		'type' => 'ad'
			    	);
					$db->insert(T_VIDEOS_TRSNS,$payment_data);
					$_SESSION['upgraded'] = true;
					$data['status'] = 200;
					$url     = PT_Link('wallet');
					if (!empty($_COOKIE['redirect_page'])) {
			            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
			            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
			        }
					$data['url'] = $url;
		        }
		        else{
		        	$data = array(
		                'status' => 400,
		                'error' => $lang->checkout_declined
		            );
		        }
		        if ($pt->user->address != $_POST['card_address'] || $pt->user->city != $_POST['card_city'] || $pt->user->state != $_POST['card_state'] || $pt->user->zip != $_POST['card_zip'] || $pt->user->country_id != $_POST['card_country'] || $pt->user->phone_number != $_POST['card_phone']) {
			    	$update_data = array('address' => PT_Secure($_POST['card_address']),'city' => PT_Secure($_POST['card_city']),'state' => PT_Secure($_POST['card_state']),'zip' => PT_Secure($_POST['card_zip']),'country_id' => PT_Secure($_POST['card_country']),'phone_number' => PT_Secure($_POST['card_phone']));
			    	$db->where('id', $pt->user->id)->update(T_USERS, $update_data);
			    }
			}
			catch (Twocheckout_Error $e) {
		        $data = array(
		            'status' => 400,
		            'error' => $e->getMessage()
		        );
		    }
		}
		else{
			$data = array(
	            'status' => 400,
	            'error' => $lang->please_check_details
	        );
		}
	}
}


if ($first == 'stripe_replenish' && $pt->config->credit_card == 'yes') {
	if (!empty($_POST['stripeToken']) && !empty($_POST['amount'])) {

		require_once('assets/import/stripe-php-3.20.0/vendor/autoload.php');
		$stripe = array(
		  "secret_key"      =>  $pt->config->stripe_secret,
		  "publishable_key" =>  $pt->config->stripe_id
		);

		\Stripe\Stripe::setApiKey($stripe['secret_key']);


	    $token = $_POST['stripeToken'];
	    try {
	        $customer = \Stripe\Customer::create(array(
	            'source' => $token
	        ));

	        $final_amount = PT_Secure($_POST['amount']);
	        $charge   = \Stripe\Charge::create(array(
	            'customer' => $customer->id,
	            'amount' => $final_amount,
	            'currency' => $pt->config->stripe_currency
	        ));
	        $amount = $final_amount / 100;
	        if ($charge) {
	        	$update  = array('wallet' => ($user->wallet += $amount));
				$db->where('id',$user->id)->update(T_USERS,$update);
				$payment_data         = array(
		    		'user_id' => $user->id,
		    		'paid_id'  => $user->id,
		    		'admin_com'    => 0,
		    		'currency'    => $pt->config->stripe_currency,
		    		'time'  => time(),
		    		'amount' => $amount,
		    		'type' => 'ad'
		    	);
				$db->insert(T_VIDEOS_TRSNS,$payment_data);
				$_SESSION['upgraded'] = true;
				$data['status'] = 200;
				$data['url'] = PT_Link('ads');
	        }
	    }
	    catch (Exception $e) {
	        $data = array(
	            'status' => 400,
	            'error' => $e->getMessage()
	        );
	        header("Content-type: application/json");
	        echo json_encode($data);
	        exit();
	    }
	}
	else{
		$data = array(
            'status' => 400,
            'error' => $lang->please_check_details
        );
	}
}


if ($first == 'bank_replenish' && $pt->config->bank_payment == 'yes') {
	if (empty($_FILES["thumbnail"]) || empty($_POST['amount'])) {
        $error = $lang->please_check_details;
    }
    if (empty($error)) {
    	$amount = PT_Secure($_POST['amount']);
    	$amount = $amount/100;
        $description = 'Wallet';
        $fileInfo      = array(
            'file' => $_FILES["thumbnail"]["tmp_name"],
            'name' => $_FILES['thumbnail']['name'],
            'size' => $_FILES["thumbnail"]["size"],
            'type' => $_FILES["thumbnail"]["type"],
            'types' => 'jpeg,jpg,png,bmp,gif'
        );
        $media         = PT_ShareFile($fileInfo);

        $mediaFilename = $media['filename'];
        if (!empty($mediaFilename)) {

        	$insert_id = $db->insert(T_BANK_TRANSFER,array('user_id' => $pt->user->id,
                                                   'description' => $description,
                                                   'price'       => $amount,
                                                   'receipt_file' => $mediaFilename,
                                                   'mode'         => 'wallet'));
            if (!empty($insert_id)) {
            	$notif_data = array(
                    'recipient_id' => 0,
                    'type' => 'bank',
                    'admin' => 1,
                    'time' => time()
                );
                
                pt_notify($notif_data);
                $data = array(
                    'message' => $lang->bank_transfer_request,
                    'status' => 200
                );
            }
        }
        else{
            $error = $lang->please_check_details;
            $data = array(
                'status' => 500,
                'message' => $error
            );
        }
    } else {
        $data = array(
            'status' => 500,
            'message' => $error
        );
    }
}



if ($first == 'get_modal') {
	$types = array('pro','wallet','pay','subscribe','rent');
	$data['status'] = 400;
	if (!empty($_POST['type']) && in_array($_POST['type'], $types)) {
		$user = $db->where('id',$pt->user->id)->getOne(T_USERS);
		
		$price = 0;
		$video_id = 0;
		$user_id = 0;
		if (!empty($_POST['price'])) {
			$price = PT_Secure($_POST['price']);
		}
		if (!empty($_POST['video_id'])) {
			$video_id = PT_Secure($_POST['video_id']);
		}
		if (!empty($_POST['user_id'])) {
			$user_id = PT_Secure($_POST['user_id']);
		}

		$pt->show_wallet = 0;
		if (!empty($user) && $_POST['type'] == 'pro' && $user->wallet >= intval($pt->config->pro_pkg_price)) {
			$pt->show_wallet = 1;
		}
		elseif (!empty($user) && $_POST['type'] == 'pay' && !empty($video_id)) {
			$video = $db->where('id',$video_id)->getOne(T_VIDEOS);
			if ($user->wallet >= $video->sell_video) {
				$pt->show_wallet = 1;
			}
		}
		elseif (!empty($user) && $_POST['type'] == 'rent' && !empty($video_id)) {
			$video = $db->where('id',$video_id)->getOne(T_VIDEOS);
			if ($user->wallet >= $video->rent_price) {
				$pt->show_wallet = 1;
			}
		}
		
		if ($_POST['type'] == 'subscribe' && !empty($user_id)) {
			$new_user = $db->where('id',$user_id)->getOne(T_USERS);
			if (!empty($new_user) && $new_user->subscriber_price > 0 && $user->wallet >= $new_user->subscriber_price) {
				$pt->show_wallet = 1;
			}
		}
		if ($_POST['type'] == 'subscribe') {
			$price = $new_user->subscriber_price;
		}
		elseif ($_POST['type'] == 'pro') {
			$price = intval($pt->config->pro_pkg_price);
		}
		elseif ($_POST['type'] == 'rent') {
			$price = $video->rent_price;
		}
		elseif ($_POST['type'] == 'pay') {
			$price = $video->sell_video;
		}

		$html = PT_LoadPage('modals/payment_modal',array('TYPE' => PT_Secure($_POST['type']),'PRICE' => $price,'VIDEO_ID' => $video_id,'USER_ID' => $user_id));
		if (!empty($html)) {
			$data['status'] = 200;
			$data['html'] = $html;
		}
	}
}
if ($first == 'paystack') {

	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0 && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$price = $_POST['amount'] * 100;

		$callback_url = PT_Link("aj/wallet/paystack_paid?type=wallet&amount=".$price);
		$result = array();
	    $reference = uniqid();

		//Set other parameters as keys in the $postdata array
		$postdata =  array('email' => $_POST['email'], 'amount' => $price,"reference" => $reference,'callback_url' => $callback_url);
		$url = "https://api.paystack.co/transaction/initialize";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));  //Post Fields
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$headers = [
		  'Authorization: Bearer '.$pt->config->paystack_secret_key,
		  'Content-Type: application/json',

		];
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$request = curl_exec ($ch);

		curl_close ($ch);

		if ($request) {
		    $result = json_decode($request, true);
		    if (!empty($result)) {
				 if (!empty($result['status']) && $result['status'] == 1 && !empty($result['data']) && !empty($result['data']['authorization_url']) && !empty($result['data']['access_code'])) {
				 	$db->where('id',$pt->user->id)->update(T_USERS,array('paystack_ref' => $reference));
				  	$data['status'] = 200;
				  	$data['url'] = $result['data']['authorization_url'];
				}
				else{
			        $data['message'] = $result['message'];
				}
			}
			else{
				$data['message'] = $lang->error_msg;
			}
		}
		else{
			$data['message'] = $lang->error_msg;
		}
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'paystack_paid') {
	$payment  = CheckPaystackPayment($_GET['reference']);
	if ($payment) {
		$amount = PT_Secure($_GET['amount'] / 100);
		$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
		$payment_data         = array(
            'user_id' => $pt->user->id,
            'paid_id'  => $pt->user->id,
            'admin_com'    => 0,
            'currency'    => $pt->config->payment_currency,
            'time'  => time(),
            'amount' => $amount,
            'type' => 'ad'
        );
        $db->insert(T_VIDEOS_TRSNS,$payment_data);
        $url     = PT_Link('wallet');
		if (!empty($_COOKIE['redirect_page'])) {
            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
        }
        header('Location: ' . $url);
        exit();
    } else {
        header('Location: ' . PT_Link('wallet'));
        exit();
    }
}
if ($first == 'cashfree' && $pt->config->cashfree_payment == 'yes') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0 && !empty($_POST['name']) && !empty($_POST['phone']) && !empty($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		
		$result = array();
	    $order_id = uniqid();
	    $name = PT_Secure($_POST['name']);
	    $email = PT_Secure($_POST['email']);
	    $phone = PT_Secure($_POST['phone']);
	    $price = PT_Secure($_POST['amount']);

	    $callback_url = PT_Link("aj/wallet/cashfree_paid?amount=".$price);


	    $secretKey = $pt->config->cashfree_secret_key;
		$postData = array( 
		  "appId" => $pt->config->cashfree_client_key, 
		  "orderId" => "order".$order_id, 
		  "orderAmount" => $price, 
		  "orderCurrency" => "INR", 
		  "orderNote" => "", 
		  "customerName" => $name, 
		  "customerPhone" => $phone, 
		  "customerEmail" => $email,
		  "returnUrl" => $callback_url, 
		  "notifyUrl" => $callback_url,
		);
		 // get secret key from your config
		 ksort($postData);
		 $signatureData = "";
		 foreach ($postData as $key => $value){
		      $signatureData .= $key.$value;
		 }
		 $signature = hash_hmac('sha256', $signatureData, $secretKey,true);
		 $signature = base64_encode($signature);
		 $cashfree_link = 'https://test.cashfree.com/billpay/checkout/post/submit';
		 if ($pt->config->cashfree_mode == 'live') {
		 	$cashfree_link = 'https://www.cashfree.com/checkout/post/submit';
		 }

		$form = '<form id="redirectForm" method="post" action="'.$cashfree_link.'"><input type="hidden" name="appId" value="'.$pt->config->cashfree_client_key.'"/><input type="hidden" name="orderId" value="order'.$order_id.'"/><input type="hidden" name="orderAmount" value="'.$price.'"/><input type="hidden" name="orderCurrency" value="INR"/><input type="hidden" name="orderNote" value=""/><input type="hidden" name="customerName" value="'.$name.'"/><input type="hidden" name="customerEmail" value="'.$email.'"/><input type="hidden" name="customerPhone" value="'.$phone.'"/><input type="hidden" name="returnUrl" value="'.$callback_url.'"/><input type="hidden" name="notifyUrl" value="'.$callback_url.'"/><input type="hidden" name="signature" value="'.$signature.'"/></form>';
		$data['status'] = 200;
		$data['html'] = $form;
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'cashfree_paid' && $pt->config->cashfree_payment == 'yes') {
	if (empty($_POST['txStatus']) || $_POST['txStatus'] != 'SUCCESS') {
		header('Location: ' . PT_Link('ads'));
        exit();
	}
	$orderId = $_POST["orderId"];
	$orderAmount = $_POST["orderAmount"];
	$referenceId = $_POST["referenceId"];
	$txStatus = $_POST["txStatus"];
	$paymentMode = $_POST["paymentMode"];
	$txMsg = $_POST["txMsg"];
	$txTime = $_POST["txTime"];
	$signature = $_POST["signature"];
	$data = $orderId.$orderAmount.$referenceId.$txStatus.$paymentMode.$txMsg.$txTime;
	$hash_hmac = hash_hmac('sha256', $data, $pt->config->cashfree_secret_key, true) ;
	$computedSignature = base64_encode($hash_hmac);
	if ($signature == $computedSignature) {
		$amount = PT_Secure($_GET['amount']);
		$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
		$payment_data         = array(
            'user_id' => $pt->user->id,
            'paid_id'  => $pt->user->id,
            'admin_com'    => 0,
            'currency'    => $pt->config->payment_currency,
            'time'  => time(),
            'amount' => $amount,
            'type' => 'ad'
        );
        $db->insert(T_VIDEOS_TRSNS,$payment_data);
        $url     = PT_Link('wallet');
		if (!empty($_COOKIE['redirect_page'])) {
            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
        }
        header('Location: ' . $url);
        exit();
    } else {
        header('Location: ' . PT_Link('wallet'));
        exit();
    }
}
if ($first == 'razorpay' && $pt->config->razorpay_payment == 'yes') {
	if (!empty($_POST['payment_id']) && !empty($_POST['order_id']) && !empty($_POST['merchant_amount']) && !empty($_POST['currency'])) {

		$payment_id = PT_Secure($_POST['payment_id']);
		$price    = PT_Secure($_POST['merchant_amount']);
		$currency_code = "INR";
	    $check = array(
		    'amount' => $price,
		    'currency' => $currency_code,
		);
		$json = CheckRazorpayPayment($payment_id,$check);
		if (!empty($json) && empty($json->error_code)) {
			$price = $price / 100;

			$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($price)));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $price,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
	        $data['status'] = 200;
	        $url     = PT_Link('wallet');
			if (!empty($_COOKIE['redirect_page'])) {
	            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
	            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
	        }
		    $data['url'] = $url;
		}
		else{
	    	$data['message'] = $json->error_description;
	    }
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'paysera' && $pt->config->razorpay_payment == 'yes') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$price = PT_Secure($_POST['amount']);
		$callback_url = PT_Link("aj/wallet/paysera_paid?amount=".$price);
		require_once 'assets/import/Paysera.php';

	    $request = WebToPay::redirectToPayment(array(
		    'projectid'     => $pt->config->paysera_project_id,
		    'sign_password' => $pt->config->paysera_sign_password,
		    'orderid'       => rand(111111,999999),
		    'amount'        => $price,
		    'currency'      => $pt->config->payment_currency,
		    'country'       => 'LT',
		    'accepturl'     => $callback_url,
		    'cancelurl'     => $callback_url,
		    'callbackurl'   => $callback_url,
		    'test'          => $pt->config->paysera_mode,
		));
		$data = array('status' => 200,
	                  'url' => $request);
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'paysera_paid' && $pt->config->paysera_payment == 'yes') {
	require_once 'assets/import/Paysera.php';
	try {
        $response = WebToPay::checkResponse($_GET, array(
            'projectid'     => $pt->config->paysera_project_id,
            'sign_password' => $pt->config->paysera_sign_password,
        ));
 
        // if ($response['test'] !== '0') {
        //     throw new Exception('Testing, real payment was not made');
        // }
        if ($response['type'] !== 'macro') {
        	header('Location: ' . PT_Link('ads'));
	        exit();
            //throw new Exception('Only macro payment callbacks are accepted');
        }
        $amount = $response['amount'] / 100;
        $currency = $response['currency'];

        if ($currency != $pt->config->payment_currency) {
        	header('Location: ' . PT_Link('ads'));
	        exit();
        }
        else{
        	$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $amount,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
	        $url     = PT_Link('wallet');
			if (!empty($_COOKIE['redirect_page'])) {
	            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
	            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
	        }
		    header('Location: ' . $url);
		    exit();
        }
	} catch (Exception $e) {
	    header('Location: ' . PT_Link('wallet'));
        exit();
	}
}
if ($first == 'iyzipay') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		require_once 'assets/import/iyzipay/samples/config.php';
		$amount = PT_Secure($_POST['amount']);
		$callback_url = PT_Link("aj/wallet/iyzipay_paid?amount=".$amount);

		
		$request->setPrice($amount);
		$request->setPaidPrice($amount);
		$request->setCallbackUrl($callback_url);
		

		$basketItems = array();
		$firstBasketItem = new \Iyzipay\Model\BasketItem();
		$firstBasketItem->setId("BI".rand(11111111,99999999));
		$firstBasketItem->setName("wallet");
		$firstBasketItem->setCategory1("wallet");
		$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
		$firstBasketItem->setPrice($amount);
		$basketItems[0] = $firstBasketItem;
		$request->setBasketItems($basketItems);
		$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());
		$content = $checkoutFormInitialize->getCheckoutFormContent();
		if (!empty($content)) {
			$db->where('id',$pt->user->id)->update(T_USERS,array('ConversationId' => $ConversationId));
			$data['html'] = $content;
			$data['status'] = 200;
		}
		else{
			$data['message'] = $lang->please_check_details;
		}
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'iyzipay_paid') {
	if (!empty($_POST['token']) && !empty($pt->user->ConversationId) && !empty($_GET['amount']) && is_numeric($_GET['amount']) && $_GET['amount'] > 0) {
		require_once('assets/import/iyzipay/samples/config.php');

		# create request class
		$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
		$request->setLocale(\Iyzipay\Model\Locale::TR);
		$request->setConversationId($pt->user->ConversationId);
		$request->setToken($_POST['token']);

		# make request
		$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

		# print result
		if ($checkoutForm->getPaymentStatus() == 'SUCCESS') {
			$amount = PT_Secure($_GET['amount']);
			$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $amount,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
	        $url     = PT_Link('wallet');
			if (!empty($_COOKIE['redirect_page'])) {
	            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
	            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
	        }
		    header('Location: ' . $url);
		    exit();
		}
		else{
			header('Location: ' . PT_Link('wallet'));
	        exit();
		}
	}
	else{
		header('Location: ' . PT_Link('wallet'));
	    exit();
	}
}
if ($first == 'move_to_wallet') {
	if ($pt->user->balance < 1) {
		$data['message'] = $lang->no_balance_to_move;
	}
	elseif (empty($_POST['amount']) || !is_numeric($_POST['amount']) || $_POST['amount'] < 1) {
		$data['message'] = $lang->please_check_details;
	}
	elseif ($_POST['amount'] > $pt->user->balance) {
		$data['message'] = $lang->more_than_balance;
	}
	else{
		$amount = PT_Secure($_POST['amount']);
		$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
		$db->where('id',$pt->user->id)->update(T_USERS,array('balance' => $db->dec($amount)));
		$data['status'] = 200;
	}
}
if ($first == 'stripe_session') {
	$data['status'] = 400;
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$amount = $_POST['amount'] * 100;
		$payment_method_types = array('card');
		$callback_url = PT_Link("aj/wallet/stripe_paid?amount=".$amount);
		try {
			require_once('assets/import/stripe/vendor/autoload.php');
			$stripe = array(
			  "secret_key"      =>  $pt->config->stripe_secret,
			  "publishable_key" =>  $pt->config->stripe_id
			);

			\Stripe\Stripe::setApiKey($stripe['secret_key']);
			$checkout_session = \Stripe\Checkout\Session::create([
			    'payment_method_types' => [implode(',', $payment_method_types)],
			    'line_items' => [[
			      'price_data' => [
			        'currency' => $pt->config->stripe_currency,
			        'product_data' => [
			          'name' => 'Top Up Wallet',
			        ],
			        'unit_amount' => $amount,
			      ],
			      'quantity' => 1,
			    ]],
			    'mode' => 'payment',
			    'success_url' => PT_Link("aj/wallet/stripe_paid?amount=".$amount),
			    'cancel_url' => PT_Link("aj/wallet/stripe_cancel?amount=".$amount),
		    ]);
		    if (!empty($checkout_session) && !empty($checkout_session['id'])) {
		    	$db->where('id',$pt->user->id)->update(T_USERS,array('StripeSessionId' => $checkout_session['id']));
		    	$data = array(
	                'status' => 200,
	                'sessionId' => $checkout_session['id']
	            );
		    }
		    else{
		    	$data = array(
	                'status' => 400,
	                'message' => $lang->error_msg
	            );
		    }
		}
		catch (Exception $e) {
			$data = array(
                'status' => 400,
                'message' => $e->getMessage()
            );
		}
	}
	else{
		$data = array(
            'status' => 400,
            'message' => $lang->empty_amount
        );
	}
}
if ($first == 'stripe_paid') {
	if (!empty($pt->user->StripeSessionId) && !empty($_GET['amount']) && is_numeric($_GET['amount'])) {
		try {
			$db->where('id',$pt->user->id)->update(T_USERS,array('StripeSessionId' => ''));
			require_once('assets/import/stripe/vendor/autoload.php');
			$stripe = array(
			  "secret_key"      =>  $pt->config->stripe_secret,
			  "publishable_key" =>  $pt->config->stripe_id
			);

			\Stripe\Stripe::setApiKey($stripe['secret_key']);
			$checkout_session = \Stripe\Checkout\Session::retrieve($pt->user->StripeSessionId);
			if ($checkout_session->payment_status == 'paid') {
				$amount = ($checkout_session->amount_total / 100);
				$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
				$payment_data         = array(
		            'user_id' => $pt->user->id,
		            'paid_id'  => $pt->user->id,
		            'admin_com'    => 0,
		            'currency'    => $pt->config->stripe_currency,
		            'time'  => time(),
		            'amount' => $amount,
		            'type' => 'ad'
		        );
		        $db->insert(T_VIDEOS_TRSNS,$payment_data);
			}
			$url     = PT_Link('wallet');
			if (!empty($_COOKIE['redirect_page'])) {
	            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
	            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
	        }
			header("Location: " . $url);
	        exit();
		} catch (Exception $e) {
			header("Location: " . PT_Link('wallet'));
	        exit();
		}
	}
	else{
		header('Location: ' . PT_Link('wallet'));
	    exit();
	}
}
if ($first == 'stripe_cancel') {
	$db->where('id',$pt->user->id)->update(T_USERS,array('StripeSessionId' => ''));
	header('Location: ' . PT_Link('wallet'));
	exit();
}
use SecurionPay\SecurionPayGateway;
use SecurionPay\Exception\SecurionPayException;
use SecurionPay\Request\CheckoutRequestCharge;
use SecurionPay\Request\CheckoutRequest;
if ($first == 'securionpay_token') {
	$data['status'] = 400;
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$amount = PT_Secure($_POST['amount']);
		require_once('assets/import/securionpay/vendor/autoload.php');
        $securionPay = new SecurionPayGateway($pt->config->securionpay_secret_key);
        $user_key = rand(1111,9999).rand(11111,99999);

        $checkoutCharge = new CheckoutRequestCharge();
        $checkoutCharge->amount(($amount * 100))->currency('USD')->metadata(array('user_key' => $user_key));

        $checkoutRequest = new CheckoutRequest();
        $checkoutRequest->charge($checkoutCharge);

        $signedCheckoutRequest = $securionPay->signCheckoutRequest($checkoutRequest);
        if (!empty($signedCheckoutRequest)) {
            $db->where('id',$pt->user->id)->update(T_USERS,array('securionpay_key' => $user_key));
            $data['status'] = 200;
            $data['token'] = $signedCheckoutRequest;
        }
        else{
            $data['message'] = $lang->error_msg;
        }
	}
	else{
		$data = array(
            'status' => 400,
            'message' => $lang->empty_amount
        );
	}
}
if ($first == 'securionpay_handle') {
	$data['status'] = 400;
	if (!empty($_POST) && !empty($_POST['charge']) && !empty($_POST['charge']['id'])) {
        $url = "https://api.securionpay.com/charges?limit=10";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERPWD, $pt->config->securionpay_secret_key.":password");
        $resp = curl_exec($curl);
        curl_close($curl);
        $resp = json_decode($resp,true);
        if (!empty($resp) && !empty($resp['list'])) {
            foreach ($resp['list'] as $key => $value) {
                if ($value['id'] == $_POST['charge']['id']) {
                	if (!empty($value['metadata']) && !empty($value['metadata']['user_key']) && !empty($value['amount'])) {
                        if ($pt->user->securionpay_key == $value['metadata']['user_key']) {
                            $db->where('id',$pt->user->id)->update(T_USERS,array('securionpay_key' => ''));
                            $amount = PT_Secure($value['amount'] / 100);
                            $db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
							$payment_data         = array(
					            'user_id' => $pt->user->id,
					            'paid_id'  => $pt->user->id,
					            'admin_com'    => 0,
					            'currency'    => $pt->config->payment_currency,
					            'time'  => time(),
					            'amount' => $amount,
					            'type' => 'ad'
					        );
					        $db->insert(T_VIDEOS_TRSNS,$payment_data);
					        $url     = PT_Link('wallet');
							if (!empty($_COOKIE['redirect_page'])) {
					            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
					            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
					        }
					        $data['url'] = $url;
                            $data['status'] = 200;
                        }
                    }
                }
            }
        }
    }
    else{
    	$data['message'] = $lang->error_msg;
    }
}
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
if ($first == 'authorize') {
	$data['status'] = 400;
	if (!empty($_POST['card_number']) && !empty($_POST['card_month']) && !empty($_POST['card_year']) && !empty($_POST['card_cvc']) && !empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$amount = PT_Secure($_POST['amount']);
		require_once('assets/import/authorize/vendor/autoload.php');
            
        $APILoginId = $pt->config->authorize_login_id;
        $APIKey = $pt->config->authorize_transaction_key;
        $refId = 'ref' . time();
        define("AUTHORIZE_MODE", $pt->config->authorize_test_mode);
        
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($APILoginId);
        $merchantAuthentication->setTransactionKey($APIKey);

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($_POST['card_number']);
        $creditCard->setExpirationDate($_POST['card_year'] . "-" . $_POST['card_month']);
        $creditCard->setCardCode($_POST['card_cvc']);

        $paymentType = new AnetAPI\PaymentType();
        $paymentType->setCreditCard($creditCard);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType("authCaptureTransaction");
        $transactionRequestType->setAmount($amount);
        $transactionRequestType->setPayment($paymentType);

        $request = new AnetAPI\CreateTransactionRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setTransactionRequest($transactionRequestType);
        $controller = new AnetController\CreateTransactionController($request);
        if ($pt->config->authorize_test_mode == 'SANDBOX') {
            $Aresponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
        }
        else{
            $Aresponse = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
        }
        if ($Aresponse != null) {
            if ($Aresponse->getMessages()->getResultCode() == 'Ok') {
                $trans = $Aresponse->getTransactionResponse();
                if ($trans != null && $trans->getMessages() != null) {
                	$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
					$payment_data         = array(
			            'user_id' => $pt->user->id,
			            'paid_id'  => $pt->user->id,
			            'admin_com'    => 0,
			            'currency'    => $pt->config->payment_currency,
			            'time'  => time(),
			            'amount' => $amount,
			            'type' => 'ad'
			        );
			        $db->insert(T_VIDEOS_TRSNS,$payment_data);
			        $url     = PT_Link('wallet');
					if (!empty($_COOKIE['redirect_page'])) {
			            $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
			            $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
			        }
			        $data['url'] = $url;
                    $data['status'] = 200;
                }
                else{
                	$error = $lang->error_msg;
                    if ($trans->getErrors() != null) {
                        $error = $trans->getErrors()[0]->getErrorText();
                    }
                    $data['message'] = $error;
                }
            }
            else{
            	$trans = $Aresponse->getTransactionResponse();
                $error = $lang->error_msg;
                if ($trans->getErrors() != null) {
                    $error = $trans->getErrors()[0]->getErrorText();
                }
                $data['message'] = $error;
            }
        }
        else{
        	$data['message'] = $lang->error_msg;
        }
	}
	else{
		$data['message'] = $lang->please_check_details;
	}
}
if ($first == 'create_yoomoney') {
	$data['status'] = 400;
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$amount = PT_Secure($_POST['amount']);
		$order_id = uniqid();
		$yoomoney_hash = rand(11111,99999).rand(11111,99999);
		$receiver = $pt->config->yoomoney_wallet_id;
		$successURL = PT_Link("aj/wallet/success_yoomoney"); 
		$form = '<form id="yoomoney_form" method="POST" action="https://yoomoney.ru/quickpay/confirm.xml">    
					<input type="hidden" name="receiver" value="'.$receiver.'"> 
					<input type="hidden" name="quickpay-form" value="donate"> 
					<input type="hidden" name="targets" value="transaction '.$order_id.'">   
					<input type="hidden" name="paymentType" value="PC"> 
					<input type="hidden" name="sum" value="'.$amount.'" data-type="number"> 
					<input type="hidden" name="successURL" value="'.$successURL.'">
					<input type="hidden" name="label" value="'.$yoomoney_hash.'">
				</form>';
	    $db->where('id',$pt->user->id)->update(T_USERS,array('yoomoney_hash' => $yoomoney_hash));
		$data['status'] = 200;
		$data['html'] = $form;
	}
	else{
		$data = array(
            'status' => 400,
            'message' => $lang->empty_amount
        );
	}
}
if ($first == 'success_yoomoney') {
	$hash = sha1($_POST['notification_type'].'&'.
	$_POST['operation_id'].'&'.
	$_POST['amount'].'&'.
	$_POST['currency'].'&'.
	$_POST['datetime'].'&'.
	$_POST['sender'].'&'.
	$_POST['codepro'].'&'.
	$pt->config->yoomoney_notifications_secret.'&'.
	$_POST['label']);

	if ($_POST['sha1_hash'] != $hash || $_POST['codepro'] == true || $_POST['unaccepted'] == true) {
		header('Location: ' . PT_Link('wallet'));
    	exit();
	}
	else{
		if (!empty($_POST['label'])) {
			$user = $db->objectBuilder()->where('yoomoney_hash',PT_Secure($_POST['label']))->getOne(T_USERS);
			if (!empty($user)) {
				$amount = PT_Secure($_POST['amount']);
				$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount),
			                                                         'yoomoney_hash' => ''));
				$payment_data         = array(
		            'user_id' => $pt->user->id,
		            'paid_id'  => $pt->user->id,
		            'admin_com'    => 0,
		            'currency'    => $pt->config->payment_currency,
		            'time'  => time(),
		            'amount' => $amount,
		            'type' => 'ad'
		        );
		        $db->insert(T_VIDEOS_TRSNS,$payment_data);
			}
		}
	}
	$url     = PT_Link('wallet');
	if (!empty($_COOKIE['redirect_page'])) {
        $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
        $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
    }
	header('Location: ' . $url);
    exit();
}
if ($first == 'get_fortumo') {
	$hash = rand(11111,55555).rand(11111,55555);
    $db->where('id',$pt->user->id)->update(T_USERS,array('fortumo_hash' => $hash));
    $data['status'] = 200;
	$data['url'] = 'https://pay.fortumo.com/mobile_payments/'.$pt->config->fortumo_service_id.'?cuid='.$hash;
}
if ($first == 'success_fortumo') {
	if (!empty($_GET) && !empty($_GET['amount']) && !empty($_GET['status']) && $_GET['status'] == 'completed' && !empty($_GET['cuid']) && !empty($_GET['price'])) {
        $fortumo_hash = PT_Secure($_GET['cuid']);
        $amount = (int) PT_Secure($_GET['price']);
        $user = $db->objectBuilder()->where('fortumo_hash',$fortumo_hash)->getOne('users');
        if (!empty($user)) {
        	$pt->user = $user;
        	$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount),
		                                                         'fortumo_hash' => ''));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $amount,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
        }
    }
    $url     = PT_Link('wallet');
	if (!empty($_COOKIE['redirect_page'])) {
        $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
        $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
    }
    header('Location: ' . $url);
    exit();
}
if ($first == 'get_coinbase') {
	$data['status'] = 400;
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$amount = (int) PT_Secure($_POST['amount']);
		try {
            $coinbase_hash = rand(1111,9999).rand(11111,99999);
            $redirect_url = PT_Link("aj/wallet/success_coinbase")."?coinbase_hash=".$coinbase_hash; 
            $cancel_url = PT_Link("aj/wallet/cancel_coinbase")."?coinbase_hash=".$coinbase_hash; 
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.commerce.coinbase.com/charges');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            $postdata =  array('name' => 'Top Up Wallet','description' => 'Top Up Wallet','pricing_type' => 'fixed_price','local_price' => array('amount' => $amount , 'currency' => $pt->config->payment_currency), 'metadata' => array('coinbase_hash' => $coinbase_hash,'amount' => $amount),"redirect_url" => $redirect_url,'cancel_url' => $cancel_url);


            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));

            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'X-Cc-Api-Key: '.$pt->config->coinbase_key;
            $headers[] = 'X-Cc-Version: 2018-03-22';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                $data = array(
                    'status' => 400,
                    'message' => curl_error($ch)
                );
            }
            curl_close($ch);

            $result = json_decode($result,true);
            if (!empty($result) && !empty($result['data']) && !empty($result['data']['hosted_url']) && !empty($result['data']['id']) && !empty($result['data']['code'])) {
                $db->where('id', $pt->user->id)->update(T_USERS, array('coinbase_hash' => $coinbase_hash,
                                                                       'coinbase_code' => $result['data']['code']));
                $data['status'] = 200;
                $data['url'] = $result['data']['hosted_url'];
            }
        }
        catch (Exception $e) {
            $data = array(
                'status' => 400,
                'message' => $e->getMessage()
            );
        }

	}
	else{
		$data = array(
            'status' => 400,
            'message' => $lang->empty_amount
        );
	}
}
if ($first == 'success_coinbase') {
	if (!empty($_GET['coinbase_hash']) && is_numeric($_GET['coinbase_hash'])) {
	    $coinbase_hash = PT_Secure($_GET['coinbase_hash']);
	    $user           = $db->objectBuilder()->where('coinbase_hash',$coinbase_hash)->getOne(T_USERS);

	    if (!empty($user)) {
	    	$pt->user = $user;
	    	$ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://api.commerce.coinbase.com/charges/'.$user->coinbase_code);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'X-Cc-Api-Key: '.$pt->config->coinbase_key;
            $headers[] = 'X-Cc-Version: 2018-03-22';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                header('Location: ' . PT_Link('wallet'));
                exit();
            }
            curl_close($ch);
            $result = json_decode($result,true);

	    	
            if (!empty($result) && !empty($result['data']) && !empty($result['data']['pricing']) && !empty($result['data']['pricing']['local']) && !empty($result['data']['pricing']['local']['amount']) && !empty($result['data']['payments']) && !empty($result['data']['payments'][0]['status']) && $result['data']['payments'][0]['status'] == 'CONFIRMED') {
            	$amount = (int)$result['data']['pricing']['local']['amount'];
            	$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount),
		                                                             'coinbase_hash' => '',
		                                                             'coinbase_code' => ''));
				$payment_data         = array(
		            'user_id' => $pt->user->id,
		            'paid_id'  => $pt->user->id,
		            'admin_com'    => 0,
		            'currency'    => $pt->config->payment_currency,
		            'time'  => time(),
		            'amount' => $amount,
		            'type' => 'ad'
		        );
		        $db->insert(T_VIDEOS_TRSNS,$payment_data);
            }
	    }
	}
	$url     = PT_Link('wallet');
	if (!empty($_COOKIE['redirect_page'])) {
        $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
        $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
    }
	header('Location: ' . $url);
    exit();
}
if ($first == 'cancel_coinbase') {
	if (!empty($_GET['coinbase_hash']) && is_numeric($_GET['coinbase_hash'])) {
        $coinbase_hash = PT_Secure($_GET['coinbase_hash']);
        $user = $db->where('coinbase_hash',$coinbase_hash)->getOne('users');
        if (!empty($user)) {
            $db->where('id', $user->id)->update('users', array('coinbase_hash' => '',
                                                               'coinbase_code' => ''));
        }
    }
    header('Location: ' . PT_Link('wallet'));
    exit();
}
if ($first == 'get_ngenius') {
	$data['status'] = 400;
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$token = GetNgeniusToken();
		if (!empty($token->message)) {
			$data['status'] = 400;
	        $data['message'] = $token->message;
		}
		elseif (!empty($token->errors) && !empty($token->errors[0]) && !empty($token->errors[0]->message)) {
			$data['status'] = 400;
	        $data['message'] = $token->errors[0]->message;
		}
		else{
			$amount = (int) PT_Secure($_POST['amount']);
			$postData = new StdClass();
		    $postData->action = "SALE";
		    $postData->amount = new StdClass();
		    $postData->amount->currencyCode = "AED";
		    $postData->amount->value = $amount;
		    $postData->merchantAttributes = new \stdClass();
	        $postData->merchantAttributes->redirectUrl = PT_Link("aj/wallet/success_ngenius");
	        //$postData->merchantAttributes->redirectUrl = "http://192.168.1.108/playtube/aj/wallet/success_ngenius";
		    $order = CreateNgeniusOrder($token->access_token,$postData);
		    if (!empty($order->message)) {
    			$data['status'] = 400;
		        $data['message'] = $order->message;
    		}
    		elseif (!empty($order->errors) && !empty($order->errors[0]) && !empty($order->errors[0]->message)) {
    			$data['status'] = 400;
		        $data['message'] = $order->errors[0]->message;
    		}
    		else{
    			$db->where('id',$pt->user->id)->update(T_USERS,array('ngenius_ref' => $order->reference));
    			$data['status'] = 200;
		        $data['url'] = $order->_links->payment->href;
    		}
		}
	}
	else{
		$data = array(
            'status' => 400,
            'message' => $lang->empty_amount
        );
	}
}
if ($first == 'success_ngenius') {
	if (!empty($_GET['ref'])) {
		$user = $db->objectBuilder()->where('ngenius_ref',PT_Secure($_GET['ref']))->getOne(T_USERS);
		if (!empty($user)) {
			$token = GetNgeniusToken();
    		if (!empty($token->message)) {
    			header('Location: ' . PT_Link('wallet'));
	        	exit();
    		}
    		elseif (!empty($token->errors) && !empty($token->errors[0]) && !empty($token->errors[0]->message)) {
    			header('Location: ' . PT_Link('wallet'));
	        	exit();
    		}
    		else{
    			$order = NgeniusCheckOrder($token->access_token,$user->ngenius_ref);
    			if (!empty($order->message)) {
	    			header('Location: ' . PT_Link('wallet'));
		        	exit();
	    		}
	    		elseif (!empty($order->errors) && !empty($order->errors[0]) && !empty($order->errors[0]->message)) {
	    			header('Location: ' . PT_Link('wallet'));
		        	exit();
	    		}
	    		else{
	    			if ($order->_embedded->payment[0]->state == "CAPTURED") {
						$amount = PT_Secure($order->amount->value);
						$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount),
				                                                             'ngenius_ref' => ''));
						$payment_data         = array(
				            'user_id' => $pt->user->id,
				            'paid_id'  => $pt->user->id,
				            'admin_com'    => 0,
				            'currency'    => $pt->config->payment_currency,
				            'time'  => time(),
				            'amount' => $amount,
				            'type' => 'ad'
				        );
				        $db->insert(T_VIDEOS_TRSNS,$payment_data);
	    			}
	    		}
    		}
		}
	}
	$url     = PT_Link('wallet');
	if (!empty($_COOKIE['redirect_page'])) {
        $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
        $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
    }
	header('Location: ' . $url);
    exit();
}
if ($first == 'get_aamarpay') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0 && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone'])) {
		$amount   = (int)PT_Secure($_POST[ 'amount' ]);
		$name   = PT_Secure($_POST[ 'name' ]);
		$email   = PT_Secure($_POST[ 'email' ]);
		$phone   = PT_Secure($_POST[ 'phone' ]);
        if ($pt->config->aamarpay_mode == 'sandbox') {
            $url = 'https://sandbox.aamarpay.com/request.php'; // live url https://secure.aamarpay.com/request.php
        }
        else {
            $url = 'https://secure.aamarpay.com/request.php';
        }
        $tran_id = rand(1111111,9999999);
        $fields = array(
            'store_id' => $pt->config->aamarpay_store_id, //store id will be aamarpay,  contact integration@aamarpay.com for test/live id
            'amount' => $amount, //transaction amount
            'payment_type' => 'VISA', //no need to change
            'currency' => 'BDT',  //currenct will be USD/BDT
            'tran_id' => $tran_id, //transaction id must be unique from your end
            'cus_name' => $name,  //customer name
            'cus_email' => $email, //customer email address
            'cus_add1' => '',  //customer address
            'cus_add2' => '', //customer address
            'cus_city' => '',  //customer city
            'cus_state' => '',  //state
            'cus_postcode' => '', //postcode or zipcode
            'cus_country' => 'Bangladesh',  //country
            'cus_phone' => $phone, //customer phone number
            'cus_fax' => 'Not¬Applicable',  //fax
            'ship_name' => '', //ship name
            'ship_add1' => '',  //ship address
            'ship_add2' => '',
            'ship_city' => '',
            'ship_state' => '',
            'ship_postcode' => '',
            'ship_country' => 'Bangladesh',
            'desc' => 'top up wallet',
            'success_url' => PT_Link("aj/wallet/success_aamarpay"), //your success route
            'fail_url' => PT_Link("aj/wallet/cancel_aamarpay"), //your fail route
            'cancel_url' => PT_Link("aj/wallet/cancel_aamarpay"), //your cancel url
            'opt_a' => '',  //optional paramter
            'opt_b' => '',
            'opt_c' => '',
            'opt_d' => '',
            'signature_key' => $pt->config->aamarpay_signature_key //signature key will provided aamarpay, contact integration@aamarpay.com for test/live signature key
        );
        $fields_string = http_build_query($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $url_forward = str_replace('"', '', stripslashes($result));
        curl_close($ch);
        $db->where('id',$pt->user->id)->update(T_USERS,array('aamarpay_tran_id' => $tran_id));
        if ($pt->config->aamarpay_mode == 'sandbox') {
            $base_url = 'https://sandbox.aamarpay.com/'.$url_forward;
        }
        else {
            $base_url = 'https://secure.aamarpay.com/'.$url_forward;
        }
        $data['status'] = 200;
		$data['url'] = $base_url;
	}
}
if ($first == 'success_aamarpay') {
	if (!empty($_POST['amount']) && !empty($_POST['mer_txnid']) && !empty($_POST['pay_status']) && $_POST['pay_status'] == 'Successful') {
		$user = $db->objectBuilder()->where('aamarpay_tran_id',PT_Secure($_POST['mer_txnid']))->getOne(T_USERS);
		if (!empty($user)) {
			$pt->user = $user;
			$amount   = (int)PT_Secure($_POST['amount']);
			$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount),
	                                                             'aamarpay_tran_id' => ''));
			$payment_data         = array(
	            'user_id' => $pt->user->id,
	            'paid_id'  => $pt->user->id,
	            'admin_com'    => 0,
	            'currency'    => $pt->config->payment_currency,
	            'time'  => time(),
	            'amount' => $amount,
	            'type' => 'ad'
	        );
	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
		}
	}
	$url     = PT_Link('wallet');
	if (!empty($_COOKIE['redirect_page'])) {
        $redirect_page = preg_replace('/on[^<>=]+=[^<>]*/m', '', $_COOKIE['redirect_page']);
        $url = preg_replace('/\((.*?)\)/m', '', $redirect_page);
    }
	header('Location: ' . $url);
    exit();
}
if ($first == 'cancel_aamarpay') {
	$db->where('id',$pt->user->id)->update(T_USERS,array('aamarpay_tran_id' => ''));
	header('Location: ' . PT_Link('wallet'));
    exit();
}
if ($first == 'get_coinpayments') {
	if (!empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
		$amount   = (int)PT_Secure($_POST[ 'amount' ]);
		if (empty($pt->config->coinpayments_coin)) {
            $pt->config->coinpayments_coin = 'BTC';
        }
        $result = coinpayments_api_call(array('key' => $pt->config->coinpayments_public_key,
                                              'version' => '1',
                                              'format' => 'json',
                                              'cmd' => 'create_transaction',
                                              'amount' => $amount,
                                              'currency1' => $pt->config->payment_currency,
                                              'currency2' => $pt->config->coinpayments_coin,
                                              'custom' => $amount,
                                              'cancel_url' => PT_Link("aj/wallet/cancel_coinpayments"),
                                              'buyer_email' => $pt->user->email));

        
        if (!empty($result) && $result['status'] == 200) {
            $db->where('id',$pt->user->id)->update(T_USERS,array('coinpayments_txn_id' => $result['data']['txn_id']));
            $data = array(
                'status' => 200,
                'url' => $result['data']['checkout_url']
            );
        }
        else{
            $data = array(
                'status' => 400,
                'message' => $result['message']
            );
        }
	}
	else{
		$data = array(
            'status' => 400,
            'message' => $lang->empty_amount
        );
	}
}
if ($first == 'cancel_coinpayments') {
	$db->where('id',$pt->user->id)->update(T_USERS,array('coinpayments_txn_id' => ''));
    header('Location: ' . PT_Link('wallet'));
    exit();
}
if ($first == 'set') {
	if (!empty($_GET['page_type']) && in_array($_GET['page_type'], array(
        'pro',
        'buy',
        'rent',
        'subscribe'
    ))) {
        if ($_GET['page_type'] == 'pro') {
            setcookie("redirect_page", PT_Link('go_pro'), time() + (60 * 60), '/');
        } else if (($_GET['page_type'] == 'buy' || $_GET['page_type'] == 'rent') && !empty($_GET['id']) && is_numeric($_GET['id'])) {
        	$video = PT_GetVideoByID(PT_Secure($_GET['id']), 1, 1,2);
        	if (!empty($video)) {
        		setcookie("redirect_page", $video->url, time() + (60 * 60), '/');
        	}
        } else if ($_GET['page_type'] == 'subscribe' && !empty($_GET['id']) && is_numeric($_GET['id'])){
        	$user = PT_UserData(PT_Secure($_GET['id']));
        	if (!empty($user)) {
        		setcookie("redirect_page", $user->url, time() + (60 * 60), '/');
        	}
        }
    }
	$data['status']  = 200;
}
if ($first == 'wallet_pay') {
	$data['status'] = 400;
	$price = 0;
	if ($_GET['pay_type'] == 'pro') {
		if ($pt->user->wallet < $pt->config->pro_pkg_price) {
			$data['message'] = "<a href='" . PT_Link('wallet') . "'>" . $lang->please_top_up_wallet . "</a>";
		}
		else{
			$price = $pt->config->pro_pkg_price;
			$update = array('is_pro' => 1,'verified' => 1,'wallet' => $db->dec($price));
		    $go_pro = $db->where('id',$pt->user->id)->update(T_USERS,$update);
		    if ($go_pro === true) {
		    	$payment_data         = array(
		    		'user_id' => $pt->user->id,
		    		'type'    => 'pro',
		    		'amount'  => $price,
		    		'date'    => date('n') . '/' . date('Y'),
		    		'expire'  => strtotime("+30 days")
		    	);

		    	$db->insert(T_PAYMENTS,$payment_data);
		    	$db->where('user_id',$pt->user->id)->update(T_VIDEOS,array('featured' => 1));
		    	$data['status'] = 200;
		    	$data['url'] = PT_Link('go_pro');
		    }
		}
	}
	if (($_GET['pay_type'] == 'buy' || $_GET['pay_type'] == 'rent') && !empty($_GET['id']) && is_numeric($_GET['id'])) {
		$video = PT_GetVideoByID(PT_Secure($_GET['id']), 1, 1,2);
    	if (!empty($video)) {
    		if (!empty($video->is_movie)) {
    			$payment_data         = array(
		    		'user_id' => $video->user_id,
		    		'video_id'    => $video->id,
		    		'paid_id'  => $pt->user->id,
		    		'admin_com'    => 0,
		    		'currency'    => $pt->config->payment_currency,
		    		'time'  => time()
		    	);
		    	if (!empty($_GET['pay_type']) && $_GET['pay_type'] == 'rent') {
	    			$payment_data['type'] = 'rent';
	    			$total = $video->rent_price;
	    		}
	    		else{
	    			$total = $video->sell_video;
	    		}
	    		if ($pt->user->wallet < $total) {
					$data['message'] = "<a href='" . PT_Link('wallet') . "'>" . $lang->please_top_up_wallet . "</a>";
					header('Content-Type: application/json');
					echo json_encode($data);
					exit();
				}
	    		$payment_data['amount'] = $total;
	    		$db->insert(T_VIDEOS_TRSNS,$payment_data);
	    		$update = array('wallet' => $db->dec($total));
		        $go_pro = $db->where('id',$pt->user->id)->update(T_USERS,$update);
    		}
    		else{

	    		if (!empty($_GET['pay_type']) && $_GET['pay_type'] == 'rent') {
	    			$admin__com = $pt->config->admin_com_rent_videos;
		    		if ($pt->config->com_type == 1) {
		    			$admin__com = ($pt->config->admin_com_rent_videos * $video->rent_price)/100;
		    			$pt->config->payment_currency = $pt->config->payment_currency.'_PERCENT';
		    		}
		    		$payment_data         = array(
			    		'user_id' => $video->user_id,
			    		'video_id'    => $video->id,
			    		'paid_id'  => $pt->user->id,
			    		'amount'    => $video->rent_price,
			    		'admin_com'    => $pt->config->admin_com_rent_videos,
			    		'currency'    => $pt->config->payment_currency,
			    		'time'  => time(),
			    		'type' => 'rent'
			    	);
			    	if ($pt->user->wallet < $video->rent_price) {
						$data['message'] = "<a href='" . PT_Link('wallet') . "'>" . $lang->please_top_up_wallet . "</a>";
						header('Content-Type: application/json');
						echo json_encode($data);
						exit();
					}
			    	$balance = $video->rent_price - $admin__com;
			    	$update = array('wallet' => $db->dec($video->rent_price));
		            $go_pro = $db->where('id',$pt->user->id)->update(T_USERS,$update);
	    		}
	    		else{
	    			$admin__com = $pt->config->admin_com_sell_videos;
		    		if ($pt->config->com_type == 1) {
		    			$admin__com = ($pt->config->admin_com_sell_videos * $video->sell_video)/100;
		    			$pt->config->payment_currency = $pt->config->payment_currency.'_PERCENT';
		    		}

		    		$payment_data         = array(
			    		'user_id' => $video->user_id,
			    		'video_id'    => $video->id,
			    		'paid_id'  => $pt->user->id,
			    		'amount'    => $video->sell_video,
			    		'admin_com'    => $pt->config->admin_com_sell_videos,
			    		'currency'    => $pt->config->payment_currency,
			    		'time'  => time()
			    	);
			    	if ($pt->user->wallet < $video->sell_video) {
						$data['message'] = "<a href='" . PT_Link('wallet') . "'>" . $lang->please_top_up_wallet . "</a>";
						header('Content-Type: application/json');
						echo json_encode($data);
						exit();
					}
			    	$balance = $video->sell_video - $admin__com;
			    	$update = array('wallet' => $db->dec($video->sell_video));
		            $go_pro = $db->where('id',$pt->user->id)->update(T_USERS,$update);

	    		}
		    		
		    	$db->insert(T_VIDEOS_TRSNS,$payment_data);
		    	
		    	$db->rawQuery("UPDATE ".T_USERS." SET `balance` = `balance`+ '".$balance."' , `verified` = 1 WHERE `id` = '".$video->user_id."'");
		    }
		    $uniq_id = $video->video_id;
            $notif_data = array(
                'notifier_id' => $pt->user->id,
                'recipient_id' => $video->user_id,
                'type' => 'paid_to_see',
                'url' => "watch/$uniq_id",
                'video_id' => $video->id,
                'time' => time()
            );
            
            pt_notify($notif_data);
		    $data['status'] = 200;
		    $data['url'] = $video->url;
    	}
	}
	if ($_GET['pay_type'] == 'subscribe' && !empty($_GET['id']) && is_numeric($_GET['id'])){
    	$user = PT_UserData(PT_Secure($_GET['id']));
    	if (!empty($user)) {
            $user_id = $user->id;
    		$admin__com = ($pt->config->admin_com_subscribers * $user->subscriber_price)/100;
    		$pt->config->payment_currency = $pt->config->payment_currency.'_PERCENT';
    		$payment_data         = array(
	    		'user_id' => $user_id,
	    		'video_id'    => 0,
	    		'paid_id'  => $pt->user->id,
	    		'amount'    => $user->subscriber_price,
	    		'admin_com'    => $pt->config->admin_com_subscribers,
	    		'currency'    => $pt->config->payment_currency,
	    		'time'  => time(),
	    		'type' => 'subscribe'
	    	);
	    	$db->insert(T_VIDEOS_TRSNS,$payment_data);
	    	$balance = $user->subscriber_price - $admin__com;
	    	$db->rawQuery("UPDATE ".T_USERS." SET `balance` = `balance`+ '".$balance."' WHERE `id` = '".$user_id."'");
	    	$insert_data         = array(
	            'user_id' => $user_id,
	            'subscriber_id' => $pt->user->id,
	            'time' => time(),
	            'active' => 1
	        );
	        $create_subscription = $db->insert(T_SUBSCRIPTIONS, $insert_data);
	        if ($create_subscription) {

	            $notif_data = array(
	                'notifier_id' => $pt->user->id,
	                'recipient_id' => $user_id,
	                'type' => 'subscribed_u',
	                'url' => ('@' . $pt->user->username),
	                'time' => time()
	            );

	            pt_notify($notif_data);
	        }
	        $update = array('wallet' => $db->dec($user->subscriber_price));
		    $go_pro = $db->where('id',$pt->user->id)->update(T_USERS,$update);
	        $data['status'] = 200;
		    $data['url'] = $user->url;
    	}
    }
}
if ($first == 'wallet_update') {
	$data['status'] = 200;
	$data['wallet'] = 0;
	$data['price'] = 0;
	if (!empty($pt->user) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
		$user = PT_UserData(PT_Secure($_GET['id']));
    	if (!empty($user)) {
    		$data['price'] = $user->subscriber_price;
    	}
		$data['wallet'] = $pt->user->wallet;
	}
}
// if ($first == 'payu') {
// 	if (!empty($_POST['card_number']) && !empty($_POST['card_month']) && !empty($_POST['card_year']) && !empty($_POST['card_cvc']) && !empty($_POST['amount']) && is_numeric($_POST['amount']) && $_POST['amount'] > 0) {
// 		require_once('assets/import/PayU.php');
// 		$arParams['ORDER_PNAME[0]'] = "Pay to subscribe";
// 		$arParams['ORDER_PRICE[0]'] = $_POST['amount'];
// 		$arParams['CC_NUMBER'] = $_POST['card_number'];
// 		$arParams['EXP_MONTH'] = $_POST['card_month'];
// 		$arParams['EXP_YEAR'] = $_POST['card_year'];
// 		$arParams['CC_CVV'] = $_POST['card_cvc'];
// 		$info = PayUPayment($arParams);
// 		if ($info['status'] == 200) {
// 			$amount = PT_Secure($_POST['amount']);
// 			$db->where('id',$pt->user->id)->update(T_USERS,array('wallet' => $db->inc($amount)));
// 			$payment_data         = array(
// 	            'user_id' => $pt->user->id,
// 	            'paid_id'  => $pt->user->id,
// 	            'admin_com'    => 0,
// 	            'currency'    => $pt->config->payment_currency,
// 	            'time'  => time(),
// 	            'amount' => $amount,
// 	            'type' => 'ad'
// 	        );
// 	        $db->insert(T_VIDEOS_TRSNS,$payment_data);
// 	        $data['status'] = 200;
// 		    $data['url'] = PT_Link('ads');
// 		}
// 		else{
// 			$data['message'] = $info['error'];
// 		}

// 	}
// 	else{
// 		$data['message'] = $lang->please_check_details;
// 	}
// }