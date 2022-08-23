<?php

namespace App\Services\Implementations;

use App\Contract\Responses\DefaultApiResponse;
use App\Mail\CreditAlertMail;
use App\Mail\DebitAlertMail;
use App\Services\Interfaces\IEMailService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EMailService implements IEMailService
{
    public DefaultApiResponse $response;
    public function __construct()
    {
        $this->response = new DefaultApiResponse();
    }

    public function sendCreditEmail($userEmail, $creditAmount): DefaultApiResponse
    {
        $title = '[Credit Alert]';
        $sendmail = Mail::to($userEmail)
        ->send(new CreditAlertMail($title, $userEmail, $creditAmount));
        $this->response->responseCode = '00';
        $this->response->message = "Mail Sent Sucssfully";
        $this->response->isSuccessful = true;
        return $this->response;
    }

    public function sendDebitEmail($userEmail, $debitAmount): DefaultApiResponse
    {
        $title = '[Debit Alert]';
        $sendmail = Mail::to($userEmail)
        ->send(new DebitAlertMail($title, $userEmail, $debitAmount));
        $this->response->responseCode = '00';
        $this->response->message = "Mail Sent Sucssfully";
        $this->response->isSuccessful = true;
        return $this->response;
    }
}
