<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
  protected $table = 'records';

  public function genre() 
  {
    return $this->belongsTo(Genre::class)->withDefault();   // a record belongs to a genre
  }
}