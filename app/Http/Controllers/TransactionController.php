<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $transactions = $user->transactions()->select(['netvalue', 'user_transactions.id as tid', 'user_transactions.created_at as cret']);
        if (isset($request->q)) {

            if (isset($request->from_date) and !empty($request->from_date)) {
                $transactions = $transactions->where('user_transactions.created_at', '>',  date('Y-m-d', strtotime($request->from_date)));
            }
            if (isset($request->to_date) and !empty($request->to_date)) {
                $transactions = $transactions->where('user_transactions.created_at', '<',  date('Y-m-d',  strtotime($request->to_date)));
            }
        }

        $transactions = $transactions->orderBy('user_transactions.id', 'desc')->paginate(10);
        /** Result returned in euro*/
        $currencyRates = \Cache::remember('currency', 60, function () {
            $link = 'http://data.fixer.io/api/latest?access_key=35dabc6ecd416fd6b968f05bc9654943';

            $returnedJson = json_decode(file_get_contents($link), true);
            return $returnedJson;
        });
        $CHF =  $currencyRates['rates']['CHF'];
        $USD = $currencyRates['rates']['USD'];
        return view('transactions.index', compact('transactions', 'CHF', 'USD'));
    }
    /**
     * Add transaction to wallet , this will affect the whole balance deposit or    * withdrawal.
     *
     */
    public function add()
    {
        $transactions = Transaction::all();
        return view('transactions.add', compact('transactions'));
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
            $userId = auth()->user()->id;
            $netValue = ($request->transaction_id == 2) ? -$request->netvalue : $request->netvalue;
            /** if 	type == 2 -*/

            $data = ['user_id' => $userId, 'netvalue' => $netValue, 'transaction_id' => $request->transaction_id];
            $user = User::find($userId);
            //check balance of user
            $newBalance = $user->balance + $netValue;
            if ($newBalance > 0) {
                $user->balance = $newBalance;
                $user->save();
                $transaction = $user->transactions()->attach($user->id, $data);
            } else {
                return redirect('/')->with('error', 'You Don\'t have Sufficient Balance');
            }
            return redirect('/')->with('success', 'Transaction created Successfully');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
