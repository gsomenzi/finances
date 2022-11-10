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
    }

    /**
     * Handle the FinancialTransaction "updated" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function updated(FinancialTransaction $financialTransaction)
    {
    }

    /**
     * Handle the FinancialTransaction "deleted" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function deleted(FinancialTransaction $financialTransaction)
    {
    }

    /**
     * Handle the FinancialTransaction "restored" event.
     *
     * @param  \App\Models\FinancialTransaction  $financialTransaction
     * @return void
     */
    public function restored(FinancialTransaction $financialTransaction)
    {
        //
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
}
