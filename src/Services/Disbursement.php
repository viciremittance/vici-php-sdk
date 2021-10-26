<?php

namespace ViciApi\Services;

use ViciApi\ViciApi;

class Disbursement extends ViciApi
{
    public function __construct()
    {
        parent::__construct();
    }

    public function bankAccountInquiry($accountNo, $bankId, $customerName, $withValidation = false, $isVaTransfer = false)
    {
        return $this->createRequest('POST', '/dg/v1/bank-account-inquiry', [
            'account_number' => $accountNo,
            'bank_id' => $bankId,
            'customer_name' => $customerName,
            'with_validation' => $withValidation,
            'is_va_transfer' => $isVaTransfer,
        ]);
    }

    public function bankList()
    {
        return $this->createRequest('GET', '/dg/v1/banks');
    }

    public function executeDisbursement($accountNo, $amount, $bankId, $customerName, $referenceId, $description = '', $isVaTransfer = false)
    {
        return $this->createRequest('POST', '/dg/v1/disbursements', [
            'account_number' => $accountNo,
            'amount' => $amount,
            'bank_id' => $bankId,
            'customer_name' => $customerName,
            'description' => $description,
            'reference_id' => $referenceId,
            'is_va_transfer' => $isVaTransfer,
        ]);
    }

    public function checkDisbursementByReferenceId($referenceId)
    {
        return $this->createRequest('GET', '/dg/v1/disbursements/reference-id/'.$referenceId);
    }

    public function checkDisbursementByDisbursementId($disbursementId)
    {
        return $this->createRequest('GET', '/dg/v1/disbursements/'.$disbursementId);
    }

    public function checkBalance()
    {
        return $this->createRequest('GET', '/cash/me/balance');
    }
}
