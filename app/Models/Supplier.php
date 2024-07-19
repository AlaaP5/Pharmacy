<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'address',
        'description'
    ];
    public function purchase(): BelongsTo
{
    return $this->belongsTo(Purchase::class,'supplier_id');
}
}
