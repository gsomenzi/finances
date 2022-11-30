<?php

namespace App\Observers;

use App\Models\FinancialAccount;

class FinancialAccountObserver
{
    /**
     * Handle the FinancialAccount "created" event.
     *
     * @param  \App\Models\FinancialAccount  $financialAccount
     * @return void
     */
    public function created(FinancialAccount $financialAccount)
    {
        $financialAccount->update(['current_balance' => $financialAccount->opening_balance ?? 0]);
        $financialAccount->update(['expected_balance' => $financialAccount->opening_balance ?? 0]);
    }

    /**
     * Handle the FinancialAccount "updated" event.
     *
     * @param  \App\Models\FinancialAccount  $financialAccount
     * @return void
     */
    public function updated(FinancialAccount $financialAccount)
    {
        //
    }

    /**
     * Handle the FinancialAccount "deleted" event.
     *
     * @param  \App\Models\FinancialAccount  $financialAccount
     * @return void
     */
    public function deleted(FinancialAccount $financialAccount)
    {
        //
    }

    /**
     * Handle the FinancialAccount "restored" event.
     *
     * @param  \App\Models\FinancialAccount  $financialAccount
     * @return void
     */
    public function restored(FinancialAccount $financialAccount)
    {
        //
    }

    /**
     * Handle the FinancialAccount "force deleted" event.
     *
     * @param  \App\Models\FinancialAccount  $financialAccount
     * @return void
     */
    public function forceDeleted(FinancialAccount $financialAccount)
    {
        //
    }
}
