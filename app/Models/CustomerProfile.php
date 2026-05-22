<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerProfile extends Model
{
    protected $table = 'customer_profiles';

    protected $primaryKey = 'profile_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'passport_number',
        'passport_expiry',
        'nationality',
        'date_of_birth',
        'frequent_flyer_no',
    ];

    protected function casts(): array
    {
        return [
            'passport_expiry' => 'date',
            'date_of_birth' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
