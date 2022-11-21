<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\FinancialAccount;

class FinancialAccountController extends ApiController
{
    public function getAll(Request $request) {
        $user = auth()->user();
        $query = $user->financialAccounts();
        $paginationData = $this->getPaginationData($request);
        $fAccounts = $query->paginate($paginationData['limit']);
        return response()->json($fAccounts, 200);
    }

    public function getOne(Request $request, $fAccount) {
        parent::getOne($request, $fAccount);
        return response()->json($fAccount, 200);
    }

    public function create(Request $request) {
        $request->validate([
            'description' => 'required',
            'type' => 'nullable|in:checking,investiment,other',
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
            'type' => 'checking',
            'opening_balance' => 0,
            'currency' => 'BRL'
        ], $input));
        return response()->json($faccount, 201);
    }

    public function update(Request $request, $fAccount) {
        parent::update($request, $fAccount);
        $request->validate([
            'description' => 'nullable',
            'type' => 'nullable|in:checking,investiment,other',
            'opening_balance' => 'nullable|numeric',
            'currency' => 'nullable|in:ALL,AFN,ARS,AWG,AUD,AZN,BSD,BBD,BDT,BYR,BZD,BMD,BOB,BAM,BWP,BGN,BRL,BND,KHR,CAD,KYD,CLP,CNY,COP,CRC,HRK,CUP,CZK,DKK,DOP,XCD,EGP,SVC,EEK,EUR,FKP,FJD,GHC,GIP,GTQ,GGP,GYD,HNL,HKD,HUF,ISK,INR,IDR,IRR,IMP,ILS,JMD,JPY,JEP,KZT,KPW,KRW,KGS,LAK,LVL,LBP,LRD,LTL,MKD,MYR,MUR,MXN,MNT,MZN,NAD,NPR,ANG,NZD,NIO,NGN,NOK,OMR,PKR,PAB,PYG,PEN,PHP,PLN,QAR,RON,RUB,SHP,SAR,RSD,SCR,SGD,SBD,SOS,ZAR,LKR,SEK,CHF,SRD,SYP,TWD,THB,TTD,TRY,TRL,TVD,UAH,GBP,USD,UYU,UZS,VEF,VND,YER,ZWD'
        ]);
        $input = $request->only(['description', 'type', 'opening_balance', 'currency', 'default']);
        $user = auth()->user();
        if ($input['default'] ?? false) {
            $user->financialAccounts()->update(['default' => false]);
        }
        $fAccount->update($input);
        $this->updateAccountBalance($fAccount);
        return response()->json($fAccount, 200);
    }

    public function delete(Request $request, $fAccount) {
        parent::delete($request, $fAccount);
        $fAccount->delete();
        return response()->json([], 204);
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
