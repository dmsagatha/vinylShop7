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
          'genre_id'   => 1,
          'created_at' => now(),
          'stock'  => 10,
          'artist' => 'The Beatles',
          'title'  => 'Please Please Me',
          'title_mbid' => 'ade577f6-6087-4a4f-8e87-38b0f8169814',
          'cover' => null
        ],
        [
          'genre_id'   => 1,
          'created_at' => now(),
          'stock'  => 1,
          'artist' => 'Queen',
          'title'  => 'Greatest Hits',
          'title_mbid' => 'fcb78d0d-8067-4b93-ae58-1e4347e20216',
          'cover' => null
        ],
        [
          'genre_id'   => 1,
          'created_at' => now(),
          'stock'  => 8,
          'artist' => 'The Rolling Stones',
          'title'  => 'Sticky Fingers',
          'title_mbid' => 'd883e644-5ec0-4928-9ccd-fc78bc306a46',
          'cover' => null
        ],
        [
          'genre_id'   => 3,
          'created_at' => now(),
          'stock'  => 10,
          'artist' => 'Shakira',
          'title'  => 'She Wolf',
          'title_mbid' => 'd355c7e2-e065-42ee-ad7f-990f9c0815f8',
          'cover' => null
        ],
        [
          'genre_id'   => 3,
          'created_at' => now(),
          'stock'  => 10,
          'artist' => 'ABBA',
          'title'  => 'Mamma Mia',
          'title_mbid' => 'f7683ed7-9497-4c62-b3e6-bc563dbe7cab',
          'cover' => null
        ],
        [
          'genre_id'   => 4,
          'created_at' => now(),
          'stock'  => 0,
          'artist' => 'Beyoncé',
          'title'  => 'Dangerously in Love',
          'title_mbid' => '773c286c-2184-4e43-8b73-d530c672fba9',
          'cover' => null
        ],
        [
          'genre_id'   => 1,
          'created_at' => now(),
          'stock'  => 5,
          'artist' => 'The Doors',
          'title'  => 'L.A. Woman',
          'title_mbid' => 'e68f23df-61e3-4264-bfc3-17ac3a6f856b',
          'cover' => null
        ],
        [
          'genre_id'   => 1,
          'created_at' => now(),
          'stock'  => 2,
          'artist' => 'Ramones',
          'title'  => 'End of the Century',
          'title_mbid' => '58dcd354-a89a-48ea-9e6e-e258cb23e11d',
          // 'cover' => 'https://coverartarchive.org/release/58dcd354-a89a-48ea-9e6e-e258cb23e11d/front-250.jpg'
          'cover'  => null
        ],
      ]
    );
  }
  
  public function down()
  {
    Schema::dropIfExists('records');
  }
}