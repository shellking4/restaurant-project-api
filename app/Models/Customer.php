<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $timestanmps = false;

    protected $fillable = [
        'name',
        'table_number'
    ];

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function payOrder(Order $order) {

    }
}
