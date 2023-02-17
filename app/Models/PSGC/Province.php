<?php

namespace App\Models\PSGC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    const CREATED_AT = null;
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'region_id',
        'code',
        'description',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function munCities()
    {
        return $this->hasMany(MunCity::class);
    }
}
