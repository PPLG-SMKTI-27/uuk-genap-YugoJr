<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transactiondetail extends Model
{
    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(transaction::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(products::class, 'product_id');
    }
}
