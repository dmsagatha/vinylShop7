<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
  protected $table = '';

  protected $fillable = [];

  public function getRouteKeyName()
  {
    return '';
  }
}