<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financial_accounts';

    protected $fillable = ['description', 'type', 'opening_balance', 'currency', 'user_id', 'default'];

    protected $hidden = ['user_id', 'deleted_at'];

    public function financialTransactions() {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
