<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecordsTable extends Migration
{
  public function up()
  {
    Schema::create('records', function (Blueprint $table) {
      $table->id();
      $table->foreignId('genre_id');    // shorthand for $table->unsignedBigInteger('id');
      $table->string('artist');
      $table->string('title');
      $table->string('title_mbid', 36)->nullable();
      $table->string('cover')->nullable();
      $table->float('price', 5, 2)->default(19.99);
      $table->unsignedInteger('stock')->default(1);
      $table->timestamps();
      
      // Foreign key relation
      $table->foreign('genre_id')->references('id')->on('genres')
        ->onDelete('cascade')
        ->onUpdate('cascade');
    });
    
    // Insert some records (inside up-function, after create-method)
    DB::table('records')->insert(
      [
        [
          'genre_id' => 1,
          'created_at' => now(),
          'stock' => 1,
          'artist' => 'Queen',
          'title' => 'Greatest Hits',
          'title_mbid' => 'fcb78d0d-8067-4b93-ae58-1e4347e20216',
          'cover' => null
        ],
        [
          'genre_id' => 1,
          'created_at' => now(),
          'stock' => 1,
          'artist' => 'Shakira',
          'title' => 'Loca',
          'title_mbid' => 'fcb78d0d-8067-4b93-ae58-1e4347e20312',
          'cover' => null
        ],
      ]
    );
  }
  
  public function down()
  {
    Schema::dropIfExists('records');
  }
}