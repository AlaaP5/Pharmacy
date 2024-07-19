<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExperyDate extends Model
{
    use HasFactory;
    protected $fillable =[
        'product_id',
        'expiry_date',
        'quantity'
    ];

    /**
     * Get the user that owns the ExperyDate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

