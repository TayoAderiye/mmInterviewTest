<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    public function AddWallet($userId,$walletId,$balance)
    {
        $this->wallet_id = $walletId;
        $this->user_id = $userId;
        $this->balance = $balance;
        $this->save();
        return $this;
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'foreign_key');
    }
}
