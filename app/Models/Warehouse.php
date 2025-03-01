<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use ActionTrait;
    protected $fillable = [
        'name',
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product_materials()
    {
        return $this->hasMany(ProductMaterial::class, 'warehouse_id');
    }
}
