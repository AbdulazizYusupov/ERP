<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use ActionTrait;
    protected $fillable = ['key','name','group_id','status'];

    public function roles()
    {
        return $this->belongsToMany('role_permissions','permission_id','role_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class,'group_id');
    }
}
