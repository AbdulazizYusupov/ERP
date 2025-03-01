<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use ActionTrait;
    protected $fillable = ['company', 'text', 'date'];

    public function entry_materials()
    {
        return $this->hasMany(EntryMaterial::class, 'entry_id');
    }
}
