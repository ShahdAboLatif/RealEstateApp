<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cities extends Model
{
    use HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'name',
    ];

    // Relationships
    public function properties()
    {
        return $this->hasMany(PropertyInfo::class, 'city_id');
    }

    public function vendorInfo()
    {
        return $this->hasMany(VendorInfo::class, 'city_id');
    }

}
