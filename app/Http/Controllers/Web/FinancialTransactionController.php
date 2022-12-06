<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinancialAccount;
use App\Models\FinancialTransaction;
use App\Models\Category;
use \Carbon\Carbon;

class FinancialTransactionController extends Controller
{

    protected $validationRules = [
        'description' => 'required',
        'value' => 'required|numeric|gt:0',
        'date' => 'required|date_format:Y-m-d',
        'type' => 'required|in:receipt,expense,transfer',
        'paid' => 'nullable',
        'paid_at' => 'required_if:paid,accepted|date_format:Y-m-d',
        'category_id' => 'required|exists:categories,id',
        'financial_account_id' => 'required|exists:financial_accounts,id',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:tags,id'
    ];

    protected $trustedFields = ['description', 'value', 'date', 'type', 'paid', 'paid_at', 'category_id', 'financial_account_id'];

    public function listView(Request $request) {
        $request->validate([
            'conta' => 'nullable|exists:financial_accounts,id',
            'dataInicio' => 'nullable|date',
            'dataFinal' => 'nullable|date'
        ]);
        $user = auth()->user();
        $query = $user->financialTransactions()->orderBy('date', 'desc');
        // FILTRO POR CONTA
        $filterAccount = $request->get('conta');
        if ($filterAccount) {
            $query->where('financial_account_id', $filterAccount); 
        }
        // FILTRO POR DATA
        $filterDate = [$request->get('dataInicio'), $request->get('dataFinal')]; 
        if ($filterDate[0] ?? 0) {
            $query->whereDate('date', '>=', $filterDate[0]);
        }
        if ($filterDate[1] ?? 0) {
            $query->whereDate('date', '<=', $filterDate[1]);
        }
        $paginationData = $this->getPaginationData($request);
        $transactions = $query->paginate($paginationData['limit']);
        return view("financial-transactions.list", compact('transactions'));
    }

    public function add(Request $request) {
        $user = auth()->user();
        $transaction = new FinancialTransaction();
        $accounts = $user->financialAccounts;
        $categories = $user->categories;
        $transaction->fill([
            'id' => 0,
            'value' => 0,
            'date' => Carbon::now()->format('Y-m-d'),
            "type" => "expense",
            "paid" => false
        ]);
        return view("financial-transactions.edit", compact('transaction', 'categories', 'accounts'));
    }

    public function edit(Request $request, FinancialTransaction $transaction) {
        if ($request->user()->cannot('update', $transaction)) {
            abort(403);
        }
        $user = auth()->user();
        $accounts = $user->financialAccounts;
        $categories = $user->categories;
        return view("financial-transactions.edit", compact('transaction', 'categories', 'accounts'));
    }

    public function save(Request $request) {
        $id = $request->get('id');
        $request->validate($this->validationRules);
        $user = auth()->user();
        $input = $request->only($this->trustedFields);
        if (!($input['paid'] ?? false)) {
            $input['paid_at'] = null;
        } else {
            $input['paid'] = true;
        }
        $account = FinancialAccount::findOrFail($input['financial_account_id']);
        $transaction = $id <= 0
            ? new FinancialTransaction()
            : $user->financialTransactions()->where('id', $id)->firstOrFail();
        if ($id > 0 && $request->user()->cannot('update', $transaction)) {
            abort(403);
        }
        if ($id > 0) {
            $transaction->update($input);
        } else {
            $transaction->fill(array_merge([
                'previous_balance' => $input['paid'] ?? false ? $account->current_balance : null,
                'paid' => $input['paid'] ?? false,
            ], $input));
            $transaction->save();
        }
        return redirect()->route('web.financial-transaction.listView');
    }

    public function togglePaid(Request $request, FinancialTransaction $transaction) {
        if ($request->user()->cannot('update', $transaction)) {
            abort(403);
        }
        $transaction->update([
            'paid' => !$transaction->paid,
            'paid_at' => $transaction->paid ? null : \Carbon\Carbon::now()->format('Y-m-d')
        ]);
        return back();
    }

    public function remove(Request $request, $transaction) {
        parent::delete($request, $transaction);
        $transaction->delete();
        return back();
    }

}
