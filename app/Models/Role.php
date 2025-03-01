<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use ActionTrait;
    protected $fillable = ['name','status'];
    public function user()
    {
        return $this->hasOne(User::class,'role_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'role_permissions','role_id','permission_id');
    }
}
