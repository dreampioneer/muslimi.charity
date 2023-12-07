<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'killed',
        'wounded',
        'missing',
    ];
}
