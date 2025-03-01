<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use ActionTrait;
    protected $fillable = ['name','status'];

    public function permissions()
    {
        return $this->hasMany(Permission::class,'group_id');
    }
}
