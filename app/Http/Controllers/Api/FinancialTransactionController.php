<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\FinancialAccount;
use App\Models\FinancialTransaction;

class FinancialTransactionController extends ApiController
{

    public function getOne(Request $request, $fTransaction) {
        parent::getOne($request, $fTransaction);
        $fTransaction->load('category')->load('tags');
        return response()->json($fTransaction, 200);
    }

    public function create(Request $request) {
        $request->validate([
            'description' => 'required',
            'value' => 'required|numeric',
            'date' => 'required|date_format:Y-m-d',
            'type' => 'required|in:receipt,expense,transfer',
            'paid' => 'nullable|boolean',
            'paid_at' => 'required_if:paid,true|date_format:Y-m-d',
            'category_id' => 'required|exists:categories,id',
            'financial_account_id' => 'required|exists:financial_accounts,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);
        $input = $request->only(['description', 'value', 'date', 'type', 'paid', 'paid_at', 'category_id', 'financial_account_id']);
        if (!($input['paid'] ?? false)) {
            $input['paid_at'] = null;
        }
        $fAccount = FinancialAccount::findOrFail($input['financial_account_id']);
        $fTransaction = FinancialTransaction::create(array_merge([
            'previous_balance' => $input['paid'] ?? false ? $fAccount->current_balance : null,
            'paid' => $input['paid'] ?? false,
        ], $input));
        if ($request->get('tags')) {
            $fTransaction->tags()->sync($request->get('tags'));
        }
        $fTransaction->load('category')->load('tags');
        return response()->json($fTransaction, 201);
    }

    public function update(Request $request, $fTransaction) {
        parent::update($request, $fTransaction);
        $request->validate([
            'description' => 'nullable',
            'value' => 'nullable|numeric',
            'date' => 'nullable|date_format:Y-m-d',
            'type' => 'nullable|in:receipt,expense,transfer',
            'paid' => 'nullable|boolean',
            'paid_at' => 'required_if:paid,true|date_format:Y-m-d',
            'category_id' => 'required|exists:categories,id',
            'financial_account_id' => 'nullable|exists:financial_accounts,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);
        $input = $request->only(['description', 'value', 'date', 'type', 'paid', 'paid_at', 'category_id', 'financial_account_id']);
        $fTransaction->update($input);
        if ($request->has('tags')) {
            $fTransaction->tags()->sync($request->get('tags') ?? []);
        }
        $fTransaction->load('category')->load('tags');
        return response()->json($fTransaction, 200);
    }

    public function delete(Request $request, $fTransaction) {
        parent::delete($request, $fTransaction);
        $fTransaction->delete();
        return response()->json([], 204);
    }
}
