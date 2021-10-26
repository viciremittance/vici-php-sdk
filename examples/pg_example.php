<?php

use ViciApi\Services\PaymentGateway;

// This is an example of implementing PaymentGateway in an application class
// PaymentGateway extends ViciApi class so developer can use some of its function that developer might need

// initialize PaymentGateway, use 'staging' || 'production' as the environment
// choose the environment config based on development stage
$pg = new PaymentGateway();

// set API base url
$pg->setBaseUrl('vici-api-url');

// set your API credentials
$pg->setCredentials('clientId', 'secret', 'signingKey');

// refresh access token to be used
$accessToken = $pg->refreshAccessToken()['access_token'];

// set access token when you need it for i.e. using stored token
$pg->setAccessToken($accessToken);

// as PaymentGateway service mainly depends on how developer handle the callbacks
// developer should validate each callbacks to ensure each requests is valid
// In this case developer should pay attention when processing the callbacks received by validating
// and responding each calls according to the Payment Gateway API Documentation

// Handling callbacks:
// ... code to handle callbacks
// ... extract request headers and body
$timestamp = 'timestamp'; // X-Bmt-Timestamp headers from callback request
$signature = 'signature'; // X-Bmt-Signature headers from callback request
$requestBody = '{rawRequestBody}'; // Raw request body from callback request
$method = 'POST'; // your callback HTTP method
$path = '/your-callback-path';  // the part after host name and port number from your callback URL
// must begins with '/'
$isValid = $pg->isValidSignature($signature, $method, $path, $timestamp, $requestBody);
if ($isValid) {
    // ... code when signature is valid
} else {
    // ... code when signature is not valid
}
// ... another line of code

// PaymentGateway API: ​/pg/v1/payment/reference-id/{reference_id}
$referenceId = 'yourPaymentReference';
$result = $pg->checkPaymentByReferenceId($referenceId);

// PaymentGateway API: ​/pg​/v1​/payment​/{payment_id}
$paymentId = '12345'; // payment id from received from callbacks
$result = $pg->checkPaymentByPaymentId($paymentId);
