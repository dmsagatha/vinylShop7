<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
  protected $table = '';

  protected $fillable = [];

  public function getRouteKeyName()
  {
    return '';
  }
}