<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financial_accounts';

    protected $fillable = ['description', 'type', 'opening_balance', 'currency', 'user_id'];

    protected $hidden = ['user_id', 'deleted_at'];

    protected $appends = ['current_balance'];

    public function getCurrentBalanceAttribute() {
        $opening_balance = $this->opening_balance;
        $receipt_value = $this->financialTransactions()->receipt()->paid()->select(['paid', 'value'])->sum('value');
        $expense_value = $this->financialTransactions()->expense()->paid()->select(['paid', 'value'])->sum('value');
        return $opening_balance + $receipt_value - $expense_value;
    }

    public function financialTransactions() {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
