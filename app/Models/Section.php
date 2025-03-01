<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use ActionTrait;
    protected $fillable = ['name'];

    public function workers()
    {
        return $this->hasMany(Worker::class, 'section_id');
    }
}
