<?php

namespace App\Http\Services\User;

use App\Enums\Enums\TransactionEnums;
use App\Http\Trait\UserTrait;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionsService
{
    use UserTrait;
    public function createDeposit(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaction = new Transaction;
            $transaction->user_id = $request->user_id;
            $transaction->amount = $request->amount;
            $transaction->transaction_type = TransactionEnums::DEPOSIT;
            $transaction->fee = 0;
            $transaction->date = now();
            $transaction->save();
            // user balance add amount
            $transaction->user->balance += $request->amount;
            $transaction->user->save();


            DB::commit();
            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
