<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'birth_date',
        'city',
        'state',
        'country_id',
        'area_id',
        'level',
        'linkedin',
        'facebook',
        'twitter',
        'instagram'
        ];

    public function user() {
        $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class);
    }

    public function area()
    {
        return $this->hasOne(Area::class);
    }
}
