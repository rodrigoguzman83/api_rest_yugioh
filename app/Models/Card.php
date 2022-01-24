<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'first_edition',
        'code',
        'type',
        'sub_type',
        'state',
        'description',
        'price',
        'image'
    ];
}
