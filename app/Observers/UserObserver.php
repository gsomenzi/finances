<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Category;
use App\Models\FinancialAccount;


class UserObserver
{
    private $defaultReceiptCategories = [
        'Salário', 'Investimentos', 'Empréstimos', 'Outras receitas'
    ];
    
    private $defaultExpenseCategories = [
        'Alimentação', 'Assinatura e Serviços', 'Bares e restaurantes', 'Casa', 'Compras', 'Cuidados pessoais', 'Dívidas e empréstimos',
        'Educação', 'Família e filhos', 'Impostos e Taxas', 'Investimentos', 'Lazer e hobbies', 'Mercado', 'Outros', 'Pets', 'Presentes e doações',
        'Roupas', 'Saúde', 'Trabalho', 'Transporte', 'Viagem'
    ];
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        FinancialAccount::create([
            'description' => 'Carteira',
            'type' => 'other',
            'opening_balance' => 0,
            'currency' => 'BRL',
            'user_id' => $user->id
        ]);

        foreach ($this->defaultReceiptCategories as $catDescription) {
            Category::create([
                'user_id' => $user->id,
                'destination' => 'receipt',
                'description' => $catDescription
            ]);
        }

        foreach ($this->defaultExpenseCategories as $catDescription) {
            Category::create([
                'user_id' => $user->id,
                'destination' => 'expense',
                'description' => $catDescription
            ]);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
