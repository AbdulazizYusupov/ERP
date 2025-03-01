<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use ActionTrait;
    protected $fillable = ['fio', 'phone', 'address', 'balance', 'longitude', 'latitude'];

    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }
}
