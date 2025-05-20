<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'notes'
    ];

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
