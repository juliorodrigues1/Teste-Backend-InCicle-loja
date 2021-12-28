<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymente_Product extends Model
{
    use HasFactory;
    protected $table = 'paymente_products';

    protected $fillable = [
        'payment_id',
        'product_id'
    ];
}
