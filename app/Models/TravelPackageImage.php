<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPackageImage extends Model
{
    protected $table = 'travel_package_images';

    public $timestamps = false;

    protected $fillable = [
        'package_id',
        'path',
        'created_at',
    ];

    public function package()
    {
        return $this->belongsTo(TravelPackage::class, 'package_id');
    }
}
