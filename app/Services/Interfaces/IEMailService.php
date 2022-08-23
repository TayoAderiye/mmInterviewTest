<?php

namespace App\Services\Interfaces;

use App\Contract\Responses\DefaultApiResponse;

interface IEMailService 
{
    public function sendCreditEmail($senderEmail, $creditAmount): DefaultApiResponse;
    public function sendDebitEmail($userEmail, $debitAmount): DefaultApiResponse;
}
