<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_invoices_price' , 'customer_name'
    ];

    public function products() : BelongsToMany
    {
        return $this->belongsToMany(Product::class,'invoice_products')->withPivot('quantity');
    }
    /**
     * Get the debt that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function debt(): BelongsTo
    {
        return $this->belongsTo(DebtRecord::class, 'invoice_id');
    }
}

