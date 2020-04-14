<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Queries\QueryFilter;

class Article extends Model
{
    use softDeletes;

    protected $dates = [
        'approval_at'
    ];

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image',
        'approval_at'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterBy($query, QueryFilter $filters, array $data)
    {
        return $filters->applyTo($query, $data);
    }
}
