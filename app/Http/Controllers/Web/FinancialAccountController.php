<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialAccount;

class FinancialAccountController extends Controller
{
    protected $validationRules = [
        'description' => 'required',
        'type' => 'required|in:checking,investiment,other',
        'opening_balance' => 'nullable|numeric',
        'currency' => 'nullable|in:ALL,AFN,ARS,AWG,AUD,AZN,BSD,BBD,BDT,BYR,BZD,BMD,BOB,BAM,BWP,BGN,BRL,BND,KHR,CAD,KYD,CLP,CNY,COP,CRC,HRK,CUP,CZK,DKK,DOP,XCD,EGP,SVC,EEK,EUR,FKP,FJD,GHC,GIP,GTQ,GGP,GYD,HNL,HKD,HUF,ISK,INR,IDR,IRR,IMP,ILS,JMD,JPY,JEP,KZT,KPW,KRW,KGS,LAK,LVL,LBP,LRD,LTL,MKD,MYR,MUR,MXN,MNT,MZN,NAD,NPR,ANG,NZD,NIO,NGN,NOK,OMR,PKR,PAB,PYG,PEN,PHP,PLN,QAR,RON,RUB,SHP,SAR,RSD,SCR,SGD,SBD,SOS,ZAR,LKR,SEK,CHF,SRD,SYP,TWD,THB,TTD,TRY,TRL,TVD,UAH,GBP,USD,UYU,UZS,VEF,VND,YER,ZWD',
        'default' => 'nullable|boolean'
    ];
    protected $trustedFields = ['description', 'type', 'opening_balance', 'currency', 'default'];

    public function listView(Request $request) {
        $user = auth()->user();
        $query = $user->financialAccounts();
        $paginationData = $this->getPaginationData($request);
        $accounts = $query->paginate($paginationData['limit']);
        return view("financial-accounts.list", compact('accounts'));
    }

    public function add(Request $request) {
        $account = new FinancialAccount();
        $account->fill([
            'id' => 0,
            'type' => 'checking',
            'opening_balance' => 0,
            "currency" => "BRL",
            "default" => false
        ]);
        return view("financial-accounts.edit", compact('account'));
    }

    public function edit(Request $request, FinancialAccount $account) {
        if ($request->user()->cannot('update', $account)) {
            abort(403);
        }
        return view("financial-accounts.edit", compact('account'));
    }

    public function save(Request $request) {
        $id = $request->get('id');
        $request->validate($this->validationRules);
        $input = $request->only($this->trustedFields);
        $user = auth()->user();
        $account = $id <= 0
            ? new FinancialAccount()
            : $user->financialAccounts()->where('id', $id)->firstOrFail();
        if ($id > 0 && $request->user()->cannot('update', $account)) {
            abort(403);
        }
        if ($input['default'] ?? false) {
            $user->financialAccounts()->update(['default' => false]);
        }
        if ($id > 0) {
            $account->update($input);
            $this->updateAccountBalance($account);
        } else {
            $account->save();
        }
        return redirect()->route('web.financial-account.listView');
    }

    public function setAsDefault(Request $request, FinancialAccount $account) {
        if ($request->user()->cannot('update', $account)) {
            abort(403);
        }
        $user = auth()->user();
        $user->financialAccounts()->update(['default' => false]);
        $account->update(["default" => true]);
        return back();
    }

    public function remove(Request $request, $account) {
        parent::delete($request, $account);
        $account->delete();
        return back();
    }

    private function updateAccountBalance(FinancialAccount $fAccount) {
        $receipt_value = $fAccount->financialTransactions()->receipt()->paid()->select(['paid', 'value'])->sum('value') || 0;
        $expense_value = $fAccount->financialTransactions()->expense()->paid()->select(['paid', 'value'])->sum('value') || 0;
        $expected_receipt_value = $fAccount->financialTransactions()->receipt()->notPaid()->select(['paid', 'value'])->sum('value') || 0;
        $expected_expense_value = $fAccount->financialTransactions()->expense()->notPaid()->select(['paid', 'value'])->sum('value') || 0;
        $current_balance = $fAccount->opening_balance + $receipt_value - $expense_value;
        $expected_balance = $current_balance + $expected_receipt_value - $expected_expense_value;
        $fAccount->update(['current_balance' => $current_balance, 'expected_balance' => $expected_balance]);
    }
}
