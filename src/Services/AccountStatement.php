<?php

namespace ViciApi\Services;

use ViciApi\ViciApi;

class AccountStatement extends ViciApi
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAccountStatament($startDate = null, $endDate = null)
    {
        $param = '';

        if (isset($endDate)) {
            $param .= '?end_date='.$endDate;
        }

        if (isset($startDate)) {
            $param .= (isset($endDate) ? '&' : '?').'start_date='.$startDate;
        }

        return $this->createRequest('GET', '/cash/transactions'.$param);
    }
}
