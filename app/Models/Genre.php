<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
  protected $table = 'genres';

  public function records() 
  {
    return $this->hasMany(Record::class);   // a genre has many records
  }
}