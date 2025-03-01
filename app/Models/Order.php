<?php

namespace App\Models;

use App\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use ActionTrait;
    protected $fillable = ['date','client_id','status','total'];

    public function order_items()
    {
        return $this->hasMany(OrderItem::class,'order_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
