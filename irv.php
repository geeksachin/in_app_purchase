<?php
header('Content-Type: text/json');
include 'itunesReceiptValidator.php';

$receipt = @$_REQUEST['receipt'];

$env = @$_REQUEST['env'];

if ((!empty($receipt) && strlen($receipt) == '15') && !empty($env)) {
	$endpoint = ($env == 'sandbox') ? itunesReceiptValidator::SANDBOX_URL : itunesReceiptValidator::PRODUCTION_URL;
	try {
	    $rv = new itunesReceiptValidator($endpoint, $receipt);

	    ($rv->getEndpoint() === itunesReceiptValidator::SANDBOX_URL) ? 'Sandbox' : 'Production';

	    $info = $rv->validateReceipt();

	    $data['code'] = '200';
		$data['message'] = $info;
		$json['response'] = $data;
		echo json_encode($json);
		die();
	} catch (Exception $ex) {
	    $error = $ex->getMessage();

	    $data['code'] = '202';
		$data['message'] = $error;
		$json['response'] = $data;
		echo json_encode($json);
		die();
	}
} else {
	$data['code'] = '300';
	$data['message'] = 'Invalid Value.';
	$json['response'] = $data;
	echo json_encode($json);
	die();
}


