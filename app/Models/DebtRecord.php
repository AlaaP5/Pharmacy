<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DebtRecord extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoice_id' ,'customer_name' , 
'debt_value' ,'debt_date'
    ];

/**
 * Get all of the comments for the DebtRecord
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
public function invoices(): HasMany
{
    return $this->hasMany(Invoice::class);
}

}
