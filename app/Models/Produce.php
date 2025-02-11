<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produce extends Model
{
    protected $fillable = ['product_id', 'count', 'defect', 'status', 'quality'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function machine_produces()
    {
        return $this->hasMany(MachineProduce::class, 'produce_id');
    }
}
