# vici-php-sdk

[![Latest Stable Version](https://poser.pugx.org/viciremittance/vici-php-sdk/v/stable)](https://packagist.org/packages/viciremittance/vici-php-sdk)
[![Total Downloads](https://poser.pugx.org/viciremittance/vici-php-sdk/downloads)](https://packagist.org/packages/viciremittance/vici-php-sdk)
[![License](https://poser.pugx.org/viciremittance/vici-php-sdk/license)](https://packagist.org/packages/viciremittance/vici-php-sdk)
[![composer.lock](https://poser.pugx.org/viciremittance/vici-php-sdk/composerlock)](https://packagist.org/packages/viciremittance/vici-php-sdk)

PHP library for calling Vici Remittance API using GuzzleHttp.

# Dependencies
* [Guzzle](http://docs.guzzlephp.org/en/stable/quickstart.html)

## Development
### Quick Start Guide
1. Install the package with Composer: `composer require viciremittance/vici-php-sdk` 
2. Use the service you need in your application class - I.e. you are using the Disbursement service (*assuming you're using PSR-4*):
 ```php
use ViciApi\Services\Disbursement;
```
3. Create a new instance of the class (`Disbursement`):
```php
$disbursement = new Disbursement();
```
4. Set Api Base Url:
```php
$disbursement->setBaseUrl($apiBaseUrl);
```
5. Set Api Credentials:
```php
$disbursement->setCredentials($clientId, $clientSecret, $signingKey);
```
6. Refresh/set `accessToken`:
```php
$accessToken = $disbursement->refreshAccessToken()['access_token'];
$disbursement->setAccessToken($accessToken);
```
7. Use one of the class method to query the API - this example will request the bank list:
```php
$banks = $disbursement->bankList();
```
Tips: all of the API response has been formatted into associative array.
```php
// extracting bank id
$bankId = $banks['banks'][0]['bank_id'];
```

## Usage
### ViciApi\ViciApi
`ViciApi` class provides the functions that is needed to configure your API calls and signature generation.
```php
// initialize ViciApi class
$vici = new ViciApi();

// set API base url
$vici->setBaseUrl($apiBaseUrl);

// set API credentials
$vici->setCredentials($clientId, $clientSecret, $signingKey);

// request API access token, this also calls setAccessToken
// you should store the access token in your system and refresh when it expires
$accessToken = $vici->refreshAccessToken()['access_token'];

// set access token that will be used to create API calls
$vici->setAccessToken($accessToken);

// request Disbursements Bank List API using createRequest
$vici->createRequest('GET', '/dg/v1/banks');

// comparing and proccessing signature from your callbacks
$isValid = $vici->isValidSignature($signatureToCompare, $method, $path, $timestamp, $body);
if ($isValid) {
  // ... code when signature is valid
} else {
  // ... code when signature is not valid
}
```

### ViciApi\Services\Disbursement
`Disbursement` class extends `ViciApi` class and simplify clients request for calling Disbursement API services. You'll be able to use some of `ViciApi` method such as `requestToken` to ease your development.
```php
$disbursement = new Disbursement();
$disbursement->setBaseUrl($apiBaseUrl);
$disbursement->setCredentials($clientId, $clientSecret, $signingKey);

// request /dg/v1/bank-account-inquiry API
$disbursement->bankAccountInquiry($accountNo, $bankId, $customerName, $withValidation);

// request /dg/v1/banks API
$disbursement->bankList();

// request ​/dg​/v1​/disbursements API
$disbursement->executeDisbursement($accountNo, $amount, $bankId, $customerName, $referenceId, $description);

// request /dg/v1/disbursements/reference-id/{reference_id} API
$disbursement->checkDisbursementByReferenceId($referenceId);

// request /dg/v1/disbursements/{disbursement_id} API
$disbursement->checkDisbursementByDisbursementId($disbursementId);

// request /cash/me/balance API
$disbursement->checkBalance();
```

### ViciApi\Services\PaymentGateway
Same as `Disbursement` class, `PaymentGateway` class also extends `ViciApi` class.
 
```php
$paymentGateway = new PaymentGateway();
$paymentGateway->setCredentials($clientId, $clientSecret, $signingKey);

// request /pg/v1/payment/reference-id/{reference_id} API
$paymentGateway->checkPaymentByReferenceId($referenceId);

// request /pg/v1/payment/{payment_id} API
$paymentGateway->checkPaymentByPaymentId($paymentId);
```

### Examples
See `examples`. 