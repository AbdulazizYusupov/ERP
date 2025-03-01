<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use ActionTrait;
    protected $fillable = ['role_id', 'permission_id'];
}
