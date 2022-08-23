<?php
namespace App\Helpers;

use App\Models\LogTransaction;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class HelperFunctions
{
    public static function encryptValue($value)
    {
        // return Crypt::encryptString($pin);
        return encrypt($value);
    }

    public static function decryptValue($value)
    {
        return decrypt($value);
    }

    public static function compareValues($value1, $value2)
    {
        if ($value1 != $value2) {
            return false;
        }
        return true;
    }

    public static function getLoggedInUser($request)
    {
        $hashedToken = $request->header('Authorization');
        $hashedToken = explode(" ", $hashedToken);
        $token = PersonalAccessToken::findToken($hashedToken[1]);
        $user = $token->tokenable;
        return $user;
    }

    public static function generateWallet()
    {
        return Str::uuid()->toString();
    }

    public static function getUserEmailbyId($id)
    {
        $user = User::where('id', $id)->first();
        return $user->email;
    }

    public static function getLogById($id)
    {
        return LogTransaction::where('id', $id)->first();
    }
}
