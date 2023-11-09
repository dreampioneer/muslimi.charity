<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonateDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'donate_history_id',
        'donate_name',
        'donate_amount',
        'donate_count',
    ];
}
