<?php

use ViciApi\Services\Disbursement;

// This is an example of implementing Disbursement in an application class
// Disbursement extends ViciApi class so developer can use some of its function that developer might need

// initialize Disbursement, use 'staging' || 'production' as the environment
// choose the environment config based on development stage
$disbursement = new Disbursement();

// set API base url
$disbursement->setBaseUrl('vici-api-url');

// set API credentials
$disbursement->setCredentials('clientId', 'secret', 'signingKey');

// refresh access token to be used
$accessToken = $disbursement->refreshAccessToken()['access_token'];

// set access token when you need it for i.e. using stored token
$disbursement->setAccessToken($accessToken);

// The purpose of Disbursement class is to help developers create Disbursements requests without hassle
// Disbursement class has prepared functions to be used to call Disbursement APIs

// Disbursement API: ​/dg​/v1​/banks
$banks = $disbursement->bankList()['banks'];

// Disbursement API: ​/dg/v1/bank-account-inquiry
$accountNo = '1234567890'; // customer bank account number
$bankId = $banks[0]['bank_id']; // bank id from banks API
$custName = 'Customer Name'; // customer name
$inquiryRes = $disbursement->bankAccountInquiry($accountNo, $bankId, $custName);

// Disbursement API: /dg/v1/disbursements
$amount = 100000; // amount to be disbursed
$referenceId = 'uniqueReferenceId'; // ... set referenceId to be used
$description = 'description'; // ... set description (optional)
$disbResult = $disbursement->executeDisbursement($accountNo, $amount, $bankId, $referenceId, $description);

// Handling callbacks:
// ... code to handle callbacks
// ... extract request headers and body
$timestamp = 'timestamp'; // X-Bmt-Timestamp headers from callback request
$signature = 'signature'; // X-Bmt-Signature headers from callback request
$requestBody = '{rawRequestBody}'; // Raw request body from callback request
$method = 'POST'; // callback HTTP method
$path = '/your-callback-path';  // the part after host name and port number from callback URL
                                // must begins with '/'
$isValid = $disbursement->isValidSignature($signature, $method, $path, $timestamp, $requestBody);
if ($isValid) {
    // ... code when signature is valid
} else {
    // ... code when signature is not valid
}
// ...

// Disbursement API: ​/dg​/v1​/disbursements​/reference-id​/{reference_id}
$result = $disbursement->checkDisbursementByReferenceId($referenceId);

// Disbursement API: ​/dg​/v1​/disbursements​/reference-id​/{reference_id}
$result = $disbursement->checkDisbursementByDisbursementId($disbResult['disbursement_id']);
