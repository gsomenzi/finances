<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tags';

    protected $fillable = ['description', 'user_id'];

    protected $hidden = ['pivot', 'user_id', 'deleted_at'];

    public function financialTransactions() {
        return $this->belongsToMany(FinancialTransaction::class);
    }

}
