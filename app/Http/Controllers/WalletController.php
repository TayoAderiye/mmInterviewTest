<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\CreateWalletRequest;
use App\Contract\Responses\DefaultApiResponse;
use App\Http\Requests\DebitWalletRequest;
use App\Services\Interfaces\IWalletService;

class WalletController extends Controller
{
    public DefaultApiResponse $response;
    public IWalletService $iwalletService;
    public function __construct(IWalletService $iwalletService)
    {
        $this->response = new DefaultApiResponse();
        $this->iwalletService = $iwalletService;
    }

    public function createWallet(CreateWalletRequest $request): JsonResponse
    {
        try {
            $response = $this->iwalletService->createWallet($request);
            if ($response->isSuccessful) {
                return response()->json($response, 201);
            }
            return response()->json($response, 400);
        } catch (\Exception $e) {
            $this->response->message = 'Processing Failed, Contact Support';
            $this->response->error = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }

    public function debitWallet(DebitWalletRequest $request): JsonResponse
    {
        try {
            $response = $this->iwalletService->debitWallet($request);
            if ($response->isSuccessful) {
                return response()->json($response, 200);
            }
            return response()->json($response, 400);
        } catch (\Exception $e) {
            $this->response->message = 'Processing Failed, Contact Support';
            $this->response->error = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }
}
