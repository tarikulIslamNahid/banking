<?php

namespace App\Http\Controllers\Api;

use App\Enums\Enums\TransactionEnums;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionsResource;
use App\Http\Services\User\TransactionsService;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionsController extends Controller
{
    private $transactionsService;
    public function __construct(
        TransactionsService $TransactionsService,
    ) {
        $this->transactionsService = $TransactionsService;
    }

    /**
    * @OA\Get(
    *     path="/transaction",
    *      operationId="getTransactions",
    *       tags={"TRANSACTION"},
    *      summary="get paginated Transactions",
    *      description="get paginated Transactions",
    *      security={{"bearer_token":{}}},
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="number of plan per page",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="page number",
    *         @OA\Schema(type="integer")
    *     ),
    *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful Insert operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          )
    * )
    */
    public function getTransactions(Request $request){
        $perPage = $request->query('perPage');
        $page = $request->query('page');

        $deposits = Transaction::query()
        ->where('user_id', auth()->id())
        ->with('user')
        ->latest()
        ->paginate($perPage, ['*'], 'page');

        return TransactionsResource::collection($deposits)->additional([
            'success' => true,
            'message' => 'Fetch Success',
        ]);
    }
    /**
    * @OA\Get(
    *     path="/transaction/deposit",
    *      operationId="getDepositTransactions",
    *       tags={"TRANSACTION"},
    *      summary="get paginated Deposit Transactions",
    *      description="get paginated Deposit Transactions",
    *      security={{"bearer_token":{}}},
    *     @OA\Parameter(
    *         name="perPage",
    *         in="query",
    *         description="number of plan per page",
    *         @OA\Schema(type="integer")
    *     ),
    *     @OA\Parameter(
    *         name="page",
    *         in="query",
    *         description="page number",
    *         @OA\Schema(type="integer")
    *     ),
    *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful Insert operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *
     *          )
    * )
    */
    public function getDepositTransactions(Request $request){
        $perPage = $request->query('perPage');
        $page = $request->query('page');

        $deposits = Transaction::query()
        ->where('transaction_type', TransactionEnums::DEPOSIT)
        ->where('user_id', auth()->id())
        ->with('user')
        ->latest()
        ->paginate($perPage, ['*'], 'page');

        return TransactionsResource::collection($deposits)->additional([
            'success' => true,
            'message' => 'Fetch Success',
        ]);
    }
}
