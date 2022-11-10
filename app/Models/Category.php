<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = ['description', 'destination', 'user_id'];

    protected $hidden = ['user_id', 'deleted_at'];

    public function scopeReceipt($query) {
        return $query->where('destination', 'receipt');
    }

    public function scopeExpense($query) {
        return $query->where('destination', 'expense');
    }
}
