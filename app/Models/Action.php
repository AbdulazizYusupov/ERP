<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['actionable_type', 'actionable_id', 'action', 'data', 'user_id'];

    protected $casts = [
        'data' => 'array',
    ];

    public function actionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
