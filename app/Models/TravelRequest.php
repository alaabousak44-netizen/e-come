<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelRequest extends Model
{
    protected $table = 'travel_requests';

    protected $fillable = [
        'name',
        'email',
        'destination_interest',
        'message',
    ];
}
