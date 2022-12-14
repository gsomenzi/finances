<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financial_accounts';

    protected $fillable = ['description', 'type', 'opening_balance', 'current_balance', 'expected_balance', 'currency', 'user_id', 'default'];

    protected $hidden = ['user_id', 'deleted_at'];

    protected $appends = ['converted_balance', 'converted_expected_balance', 'exchange_rate_updated_at', 'translated_type'];

    protected $translated_types = [
        'checking' => "Conta corrente",
        'investiment' => "Investimento",
        'other' => 'Outro'
    ];

    public function getTranslatedTypeAttribute() {
        return $this->translated_types[$this->type] ?? $this->type;
    }

    public function getConvertedBalanceAttribute() {
        if ($this->currency === 'BRL') {
            return $this->current_balance;
        } else {
            $exchangeRate = ExchangeRate::where('code', $this->currency)->first();
            if ($exchangeRate) {
                return number_format($this->current_balance / $exchangeRate->value, 2, '.', '');
            } else {
                return $this->current_balance;
            }
        }
    }

    public function getConvertedExpectedBalanceAttribute() {
        if ($this->currency === 'BRL') {
            return $this->expected_balance;
        } else {
            $exchangeRate = ExchangeRate::where('code', $this->currency)->first();
            if ($exchangeRate) {
                return number_format($this->expected_balance / $exchangeRate->value, 2, '.', '');
            } else {
                return $this->expected_balance;
            }
        }
    }

    public function getExchangeRateUpdatedAtAttribute() {
        if ($this->currency === 'BRL') {
            return null;
        } else {
            $exchangeRate = ExchangeRate::where('code', $this->currency)->first();
            if ($exchangeRate) {
                return $exchangeRate->last_updated_at;
            } else {
                return null;
            }
        }
    }

    public function financialTransactions() {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
