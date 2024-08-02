<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'quantity',
        'ship_date',
        'status',
        'complete',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }
}
