<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    protected $fillable=['name'];


/**
 * Get the user that owns the Category
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function purchase(): BelongsTo
{
    return $this->belongsTo(Purchase::class,'category_id');
}

public function product(): BelongsTo
{
    return $this->belongsTo(Product::class,'category_id');
}
}