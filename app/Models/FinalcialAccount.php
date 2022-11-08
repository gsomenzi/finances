<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinalcialAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'financial_accounts';

    protected $fillable = ['description', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
