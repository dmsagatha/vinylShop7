<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $table = 'orders';

  public function user() 
  {
    return $this->belongsTo(User::class)->withDefault();   // an order belongs to a user
  }

  public function orderlines() 
  {
    return $this->hasMany(Orderline::class);   // an order has many orderlines
  }
}