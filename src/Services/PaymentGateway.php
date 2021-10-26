<?php

namespace ViciApi\Services;

use ViciApi\ViciApi;

class PaymentGateway extends ViciApi
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkPaymentByReferenceId($referenceId)
    {
        return $this->createRequest('GET', '/pg/v1/payment/reference-id/'.$referenceId);
    }

    public function checkPaymentByPaymentId($paymentId)
    {
        return $this->createRequest('GET', '/pg/v1/payment/'.$paymentId);
    }
}
