<?php
namespace App\Services\Interfaces;


use App\Contract\Responses\DefaultApiResponse;
use App\Http\Requests\CreateWalletRequest;
use App\Http\Requests\DebitWalletRequest;

interface IWalletService 
{
    public function createWallet(CreateWalletRequest $request): DefaultApiResponse;
    public function debitWallet(DebitWalletRequest $request): DefaultApiResponse;
}