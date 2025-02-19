<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['name','slug'];

    public function entry_materials()
    {
        return $this->hasMany(EntryMaterial::class,'material_id');
    }

    public function warehouse_materials()
    {
        return $this->hasMany(WarehouseMaterial::class,'product_id');
    }
}
