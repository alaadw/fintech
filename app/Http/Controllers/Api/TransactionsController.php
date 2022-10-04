<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;

class TransactionsController extends Controller
{
    public function listTransactions()
    {

        $user = User::find(auth('sanctum')->user()->id);

        $transactions = $user->transactions()->select(['netvalue', 'user_transactions.id as tid', 'user_transactions.created_at as cret'])->orderBy('user_transactions.id', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => "All Transactions",
            'transactions' => $transactions
        ], 200);
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'netvalue' => 'required|numeric|between:1,1000000000.999',
                'transaction_id' => 'required'
            ],
            [
                'netvalue.required' => 'Please Fill the Value',

                'transaction_id.required' => ' Please Choose One of Transactions Types',


            ]
        );
        try {
            $userId = auth('sanctum')->user()->id;
            $netValue = ($request->transaction_id == 2) ? -$request->netvalue : $request->netvalue;
            $data = ['user_id' => $userId, 'netvalue' => $netValue, 'transaction_id' => $request->transaction_id];

            $user = User::find($userId);
            $newBalance = $user->balance + $netValue;

            $message = 'Added Successfully';
            $status = true;
            if ($newBalance > 0) {
                $user->balance = $newBalance;
                $user->save();
                $transaction = $user->transactions()->attach($user->id, $data);
            } else {
                $message = 'Insufficient Balance';
                $status = false;
            }

            return response()->json([
                'status' => $status,
                'message' => $message,
                'currentbalance' => $newBalance
            ], 200);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
