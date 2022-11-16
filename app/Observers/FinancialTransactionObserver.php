<?php

namespace App\Observers;

use App\Models\FinancialTransaction;

class FinancialTransactionObserver
{

    /**
     * Handle the FinancialTransaction "created" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function created(FinancialTransaction $financialTransaction)
    {
        $this->updateAccountCurrentBalance($financialTransaction);
    }

    /**
     * Handle the FinancialTransaction "updated" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function updated(FinancialTransaction $financialTransaction)
    {
        $this->updateAccountCurrentBalance($financialTransaction);
    }

    /**
     * Handle the FinancialTransaction "deleted" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function deleted(FinancialTransaction $financialTransaction)
    {
        $this->updateAccountCurrentBalance($financialTransaction);
    }

    /**
     * Handle the FinancialTransaction "restored" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function restored(FinancialTransaction $financialTransaction)
    {
        $this->updateAccountCurrentBalance($financialTransaction);
    }

    /**
     * Handle the FinancialTransaction "force deleted" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function forceDeleted(FinancialTransaction $financialTransaction)
    {
        //
    }

    private function updateAccountCurrentBalance(FinancialTransaction $financialTransaction) {
        $fAccount = $financialTransaction->financialAccount;
        $receipt_value = $fAccount->financialTransactions()->receipt()->paid()->select(['paid', 'value'])->sum('value') || 0;
        $expense_value = $fAccount->financialTransactions()->expense()->paid()->select(['paid', 'value'])->sum('value') || 0;
        $fAccount->update(['current_balance' => $fAccount->opening_balance + $receipt_value - $expense_value]);
    }
}
