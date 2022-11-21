<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financial_transactions';

    protected $fillable = [
        'description', 'value', 'date', 'type', 'paid', 'paid_at', 'previous_balance', 'category_id', 'financial_account_id', 'financial_transaction_id'
    ];

    protected $hidden = ['category_id', 'financial_account_id', 'financial_transaction_id', 'deleted_at'];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'paid_at' => 'date:Y-m-d',
    ];

    public function scopeNotPaid($query) {
        return $query->where('paid', 0);
    }

    public function scopePaid($query) {
        return $query->where('paid', 1);
    }

    public function scopeExpense($query) {
        return $query->where('type', 'expense');
    }

    public function scopeReceipt($query) {
        return $query->where('type', 'receipt');
    }

    public function scopeTransfer($query) {
        return $query->where('type', 'transfer');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function financialAccount() {
        return $this->belongsTo(FinancialAccount::class);
    }

    public function destination() {
        return $this->belongsTo(FinancialAccount::class, 'destination_id');
    }

    public function originalTransaction() {
        return $this->belongsTo(FinancialTransaction::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
}
