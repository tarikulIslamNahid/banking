<?php

namespace App\Http\Services\User;

use App\Enums\Enums\TransactionEnums;
use App\Enums\UserEnums;
use App\Http\Trait\UserTrait;
use App\Models\Transaction;
use App\Models\User;
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

    public function createWithdrawal(Request $request){
        DB::beginTransaction();

        $user = User::find($request->user_id);

        if($user->balance < $request->amount){
            throw new \Exception('Insufficient balance');
        }
        try {
            $transaction = new Transaction;
            $transaction->user_id = $request->user_id;
            $transaction->amount = $request->amount;
            $transaction->transaction_type = TransactionEnums::WITHDRAWAL;
            $transaction->fee = $this->getFee($user, $request->amount);
            $transaction->date = now();
            $transaction->save();
            // user balance add amount
            $transaction->user->balance -= $request->amount + $transaction->fee;
            $transaction->user->save();

            DB::commit();
            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    public function getFee($user, $amount){
        $fee =0;
        $totalWithdrawal = Transaction::where('user_id', $user->id)
        ->where('transaction_type', TransactionEnums::WITHDRAWAL)
        ->sum('amount');
        if($user->account_type == $this->individual){

            $totalWithdrawalCurrentMonth = Transaction::where('user_id', $user->id)
            ->where('transaction_type', TransactionEnums::WITHDRAWAL)
            ->whereMonth('date', now()->month)
            ->sum('amount');

            if(now()->dayOfWeek == 5 || $totalWithdrawal <= 1000 || $totalWithdrawalCurrentMonth >= 5000){
                $fee = 0;
            }else{
                $fee = $amount * $this->individualFee / 100;

            }
        }

        if($user->account_type == $this->business){
            if($totalWithdrawal >= 50000){
                $fee = $amount * $this->businessFeeAfterFiftyThousand / 100;
            }
            $fee = $amount * $this->businessFee / 100;
        }

        return $fee;
    }
}
