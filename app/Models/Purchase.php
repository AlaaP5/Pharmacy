<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable =[
        'name','category_id','net_price','salling_price','quantity',
        'image','expiry_date','supplier_id','paracode'
    ];

/**
 * Get the user associated with the Purchase
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasOne
 */
public function supplier(): HasOne
{
    return $this->hasOne(Supplier::class,);
}
public function category(): HasOne
{
    return $this->hasOne(Category::class,);
}
public function product(): BelongsTo
{
    return $this->belongsTo(Product::class,'purchase_id');
}


}
