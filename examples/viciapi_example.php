<?php

use ViciApi\ViciApi;

// This is an example of implementing ViciApi in an application class

// initialize ViciApi, use 'staging' || 'production' as the environment
// choose the environment config based on your development stage
$viciApi = new ViciApi();

// set API base url
$disbursement->setBaseUrl('vici-api-url');

// set API credentials
$viciApi->setCredentials('clientId', 'secret', 'signingKey');

// refresh access token, you can add the scope as the parameter if needed to add security measure
// this function also sets $accessToken variable in the class that is used when calling API
$accessToken = $viciApi->refreshAccessToken()['access_token'];

// set access token when you need it for i.e. using stored token
$viciApi->setAccessToken($accessToken);

// start creating your request, here are some examples:
// Disbursement API: /dg/v1/bank-account-inquiry
$inquiryBody = [
    'account_number' => '123455678', // customer bank account number
    'bank_id' => 1, // bank id from banks API
    'customer_name' => 'customer name', // customer name
    'with_validation' => true, // optional: use this to get validity percentage from the API
];
$inquiryResult = $viciApi->createRequest('POST', '/dg/v1/bank-account-inquiry', $inquiryBody);

// Disbursement API: /dg/v1/banks API
$banks = $viciApi->createRequest('GET', '/dg/v1/banks');

// other API request for Disbursement and Payment Gateway Service can also be called using createRequest function,
// you just need to set your request body accordingly

// Handling callbacks:
// ... code to handle callbacks
// ... extract request headers and body
$timestamp = 'timestamp'; // X-Bmt-Timestamp headers from callback request
$signature = 'signature'; // X-Bmt-Signature headers from callback request
$requestBody = '{rawRequestBody}'; // Raw request body from callback request
$method = 'POST'; // your callback HTTP method
$path = '/your-callback-path';  // the part after host name and port number from your callback URL
// must begins with '/'
$isValid = $viciApi->isValidSignature($signature, $method, $path, $timestamp, $requestBody);
if ($isValid) {
    // ... code when signature is valid
} else {
    // ... code when signature is not valid
}
// ...

// to help with your API calls, see Disbursement and PaymentGateway service class usage example in:
// disbursement_example.php
// pg_example.php
