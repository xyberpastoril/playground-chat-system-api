<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'barangay_id',
        'house_lot_number',
        'street',
        'village_subdivision',
        'unit_floor',
        'building',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }
}
