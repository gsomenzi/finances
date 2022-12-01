<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialTransaction;
use \Carbon\Carbon;

class FinancialTransactionController extends Controller
{
    public function listView(Request $request) {
        return view("financial-transactions.list");
    }

    public function add(Request $request) {
        $transaction = new FinancialTransaction();
        $transaction->fill([
            'id' => 0,
            'value' => 0,
            'date' => Carbon::now()->format('Y-m-d'),
            "type" => "expense",
            "paid" => false
        ]);
        dd($transaction->toArray());
        return view("financial-transactions.edit", compact('transaction'));
    }
}
