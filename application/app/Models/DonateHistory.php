<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonateHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'price',
        'transaction_id',
        'dedicate_this_donation',
        'is_zakat',
        'is_monthly',
    ];

    public function detail(){
        return $this->hasMany(DonateDetail::class, 'donate_history_id', 'id');
    }
}
