<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTransaction extends Model
{
    use HasFactory;

    public function AddTransaction($userEmailOfSourceWallet, $userEmailOfDestinationWallet,$amount)
    {
        $this->debitor_email = $userEmailOfSourceWallet;
        $this->amount = $amount;
        $this->creditor_email = $userEmailOfDestinationWallet;
        $this->save();
    }

    public function UpdateTransaction($fromDb)
    {
        $fromDb->processed = "Y";
        $fromDb->save();
    }
}