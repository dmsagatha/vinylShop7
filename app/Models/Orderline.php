<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderline extends Model
{
  protected $table = 'orderlines';

  public function getRouteKeyName()
  {
    return 'artist';
  }

  public function order() 
  {
    return $this->belongsTo(Order::class)->withDefault();   // an orderline belongs to an order
  }
}