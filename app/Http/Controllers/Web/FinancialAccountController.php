<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialAccount;

class FinancialAccountController extends Controller
{
    public function listView(Request $request) {
        $user = auth()->user();
        $query = $user->financialAccounts();
        $paginationData = $this->getPaginationData($request);
        $accounts = $query->paginate($paginationData['limit']);
        return view("financial-accounts.list", compact('accounts'));
    }

    public function addView(Request $request) {
        return view("financial-accounts.add");
    }

    public function create(Request $request) {
        $request->validate([
            'description' => 'required',
            'type' => 'required|in:checking,investiment,other',
            'opening_balance' => 'nullable|numeric',
            'currency' => 'nullable|in:ALL,AFN,ARS,AWG,AUD,AZN,BSD,BBD,BDT,BYR,BZD,BMD,BOB,BAM,BWP,BGN,BRL,BND,KHR,CAD,KYD,CLP,CNY,COP,CRC,HRK,CUP,CZK,DKK,DOP,XCD,EGP,SVC,EEK,EUR,FKP,FJD,GHC,GIP,GTQ,GGP,GYD,HNL,HKD,HUF,ISK,INR,IDR,IRR,IMP,ILS,JMD,JPY,JEP,KZT,KPW,KRW,KGS,LAK,LVL,LBP,LRD,LTL,MKD,MYR,MUR,MXN,MNT,MZN,NAD,NPR,ANG,NZD,NIO,NGN,NOK,OMR,PKR,PAB,PYG,PEN,PHP,PLN,QAR,RON,RUB,SHP,SAR,RSD,SCR,SGD,SBD,SOS,ZAR,LKR,SEK,CHF,SRD,SYP,TWD,THB,TTD,TRY,TRL,TVD,UAH,GBP,USD,UYU,UZS,VEF,VND,YER,ZWD',
            'default' => 'nullable|boolean'
        ]);
        $input = $request->only(['description', 'type', 'opening_balance', 'currency', 'default']);
        $user = auth()->user();
        if ($input['default'] ?? false) {
            $user->financialAccounts()->update(['default' => false]);
        }
        $input['current_balance'] = $input['opening_balance'] ?? 0;
        $input['expected_balance'] = $input['opening_balance'] ?? 0;
        $faccount = FinancialAccount::create(array_merge([
            'user_id' => $user->id,
            'opening_balance' => 0,
            'currency' => 'BRL'
        ], $input));
        return redirect()->route('web.financial-account.listView');
    }

    public function remove(Request $request, $account) {
        parent::delete($request, $account);
        $account->delete();
        return back();
    }
}
