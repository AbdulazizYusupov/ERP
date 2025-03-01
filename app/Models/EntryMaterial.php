<?php

namespace App\Models;

use App\Traits\ActionTrait as TraitsActionTrait;
use Illuminate\Database\Eloquent\Model;

class EntryMaterial extends Model
{
    use TraitsActionTrait;
    protected $fillable = [
        'entry_id',
        'material_id',
        'quantity',
        'price',
        'total',
        'unit'
    ];

    public function entry()
    {
        return $this->belongsTo(Entry::class,'entry_id');
    }

    public function material()
    {
        return $this->belongsTo(Material::class,'material_id');
    }
}
