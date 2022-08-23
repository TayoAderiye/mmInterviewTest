<?php
namespace App\Services\Implementations;

use App\Models\User;
use App\Models\Wallet;
use App\Helpers\HelperFunctions;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\DebitWalletRequest;
use App\Http\Requests\CreateWalletRequest;
use App\Services\Interfaces\IWalletService;
use App\Contract\Responses\DefaultApiResponse;
use App\Models\LogTransaction;

class WalletService implements IWalletService
{

    public DefaultApiResponse $response;
    public function __construct()
    {
        $this->response = new DefaultApiResponse();
    }

    public function createWallet(CreateWalletRequest $request): DefaultApiResponse
    {
        //get logged in user
        $userObject = HelperFunctions::getLoggedInUser($request);
        //check if pin is the same on user table provided
        $decryptPin = HelperFunctions::decryptValue($userObject->pin);
        $isPinValid = HelperFunctions::compareValues($decryptPin, $request->pin);

        if (!$isPinValid) {
            $this->response->responseCode = '1';
            $this->response->message = "Invalid Pin";
            return $this->response;
        }
        //check if user has a wallet already

        $checker = Wallet::where('user_id', $userObject->id)->first();
        if (empty($checker)) {
            $walletGenerated = HelperFunctions::generateWallet();
            $walletInstance = new Wallet();
            $walletInstance->AddWallet($userObject->id, $walletGenerated, $request->amount);

            $this->response->responseCode = '0';
            $this->response->message = "New Walled Created for User " . $userObject->id;
            $this->response->isSuccessful = true;
            $this->response->data = [
                "walletId" => $walletGenerated
            ];
            return $this->response;
        }
        $this->response->responseCode = '1';
        $this->response->message = "User already has a wallet";
        return $this->response;
        
    }

    public function debitWallet(DebitWalletRequest $request): DefaultApiResponse
    {
        $userObject = HelperFunctions::getLoggedInUser($request);
        //check if sourceWallet is valid
        $checkSourceWallet = Wallet::where('wallet_id', $request->sourceWallet)->first();
        if (empty($checkSourceWallet)) {

            $this->response->responseCode = '1';
            $this->response->message = "Invalid source wallet Id";
            return $this->response;
        }
        //check pin
        $decryptPin = HelperFunctions::decryptValue($userObject->pin);
        $isPinValid = HelperFunctions::compareValues($decryptPin, $request->pin);

        if (!$isPinValid) {
            $this->response->responseCode = '1';
            $this->response->message = "Invalid Pin";
            return $this->response;
        }
        //check is wallet belongs to signed in user
        
        $isUserWallet = HelperFunctions::compareValues($checkSourceWallet->user_id, $userObject->id);
        if (!$isUserWallet) {

            $this->response->responseCode = '1';
            $this->response->message = "Access Denied, You dont have access to this wallet";
            return $this->response;
        }
        //check balance of source wallet
        if ($checkSourceWallet->balance < $request->amount) {
            $this->response->responseCode = '1';
            $this->response->message = "Insufficient Balance";
            return $this->response;
        }

        $checkDestinationWallet = Wallet::where('wallet_id', $request->destinationWallet)->first();
        if (empty($checkDestinationWallet)) {

            $this->response->responseCode = '1';
            $this->response->message = "Invalid destination wallet Id";
            return $this->response;
        }

        //debit source wallet
        $newBalance = (int)$checkSourceWallet->balance - (int)$request->amount;

        $checkSourceWallet->balance = strval($newBalance);
        $checkSourceWallet->save();
        //credit destination wallet
        $newBalance2 = (int)$checkDestinationWallet->balance + (int)$request->amount;

        $checkDestinationWallet->balance = strval($newBalance2);
        $checkDestinationWallet->save();
        
        $userEmailOfSourceWallet = HelperFunctions::getUserEmailbyId($checkSourceWallet->user_id);
        $userEmailOfDestinationWallet = HelperFunctions::getUserEmailbyId($checkDestinationWallet->user_id);
        $amount = $request->amount;
        $logTranInstance = new LogTransaction();
        $logTranInstance->AddTransaction($userEmailOfSourceWallet, $userEmailOfDestinationWallet,$amount);
        $this->response->responseCode = '0';
        $this->response->message = "Debit Succesful";
        $this->response->isSuccessful = true;
        return $this->response;
    }

}
// $this->debitor_email
//         $this->amount
//         $this->creditor_email
//         $this->action
//         $this->balance


//         $table->string("debitor_email")->nullable();
//         $table->integer("amount");
//         $table->string("creditor_email")->nullable();