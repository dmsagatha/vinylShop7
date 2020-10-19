<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenresTable extends Migration
{
  public function up()
  {
    Schema::create('genres', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->timestamps();
    });
    
    // Insert some genres (inside up-function, after create-method)
    DB::table('genres')->insert(
      [
        ['name' => 'pop/rock', 'created_at' => now()],
        ['name' => 'blues', 'created_at' => now()],
        ['name' => 'dance', 'created_at' => now()],
        ['name' => 'dubstep', 'created_at' => now()],
        ['name' => 'electro', 'created_at' => now()],
        ['name' => 'folk', 'created_at' => now()],
        ['name' => 'hiphop', 'created_at' => now()],
        ['name' => 'jazz', 'created_at' => now()],
        ['name' => 'punk', 'created_at' => now()],
        ['name' => 'reggae', 'created_at' => now()],
        ['name' => 'techno', 'created_at' => now()],
      ]
    );
  }
  
  public function down()
  {
    Schema::dropIfExists('genres');
  }
}