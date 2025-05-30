<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use ActionTrait;
    protected $fillable = ['name','image','slug','price'];

    public function product_materials()
    {
        return $this->hasMany(ProductMaterial::class, 'product_id');
    }

    public function warehouse_materials()
    {
        return $this->hasMany(WarehouseMaterial::class, 'product_id');
    }

    public function produces()
    {
        return $this->hasMany(Produce::class, 'product_id');
    }
}
