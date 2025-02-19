<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseMaterial extends Model
{
    protected $fillable = ['warehouse_id','product_id','value','type'];

    public function material()
    {
        return $this->belongsTo(Material::class,'product_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
