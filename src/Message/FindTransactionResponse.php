<?php

namespace Omnipay\PagSeguro\Message;

use Carbon\Carbon;
use Omnipay\Common\Message\AbstractResponse;

class FindTransactionResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return isset($this->data->error) ? false : true;
    }

    public function getTransactionReference()
    {
        return $this->isSuccessful() ? $this->data->code : null;
    }

    public function getTransactionDate()
    {
        return $this->isSuccessful() ? $this->data->date : null;
    }
}
