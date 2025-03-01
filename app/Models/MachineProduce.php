<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class MachineProduce extends Model
{
    use ActionTrait;
    protected $fillable = ['machine_id', 'produce_id', 'count', 'defect', 'user_id','quality','status'];

    public function machine()
    {
        return $this->belongsTo(Machine::class, 'machine_id');
    }

    public function produce()
    {
        return $this->belongsTo(Produce::class, 'produce_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
