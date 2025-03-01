<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use ActionTrait;
    protected $fillable = ['name','status'];

    public function machine_produces()
    {
        return $this->hasMany(MachineProduce::class, 'machine_id');
    }
}
