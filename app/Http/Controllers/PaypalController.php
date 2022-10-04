<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class PaypalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function pay(Request $request)
    {

        //get following from paypal
        // id = 82M16139Y1439491N
        $userId = auth()->user()->id;
        $details = [
            'id' => $request->id, 'time' => $request->time, 'email' => $request->email,
            'payer_id' => $request->payer_id
        ];
        $netValue = $request->v;
        $data = ['user_id' => $userId, 'netvalue' => $netValue, 'transaction_id' => 1, 'details' => serialize($details)];
        $user = User::find($userId);
        /** @TODO : check if id of transaction is related to value before save */
        $newBalance = $user->balance + $netValue;
        if ($newBalance > 0) {
            $user->balance = $newBalance;
            $user->save();
            $transaction = $user->transactions()->attach($user->id, $data);
        }
    }
}
