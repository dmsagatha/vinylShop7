<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();     // shorthand for $table->bigIncrements('id');
      $table->string('name');
      $table->string('email')->unique();
      $table->boolean('active')->default(true);
      $table->boolean('admin')->default(false);
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();
    });
    
    // Insert some users (inside the up-function!)
    DB::table('users')->insert(
      [
        [
          'name'  => 'Super Admin',
          'email' => 'superadmin@admin.net',
          'admin' => true,
          'password'   => Hash::make('superadmin'),
          'created_at' => now(),
          'email_verified_at' => now()
        ],
        [
          'name'  => 'Agatha',
          'email' => 'agatha@tmp.com',
          'admin' => false,
          'password'   => Hash::make('agatha'),
          'created_at' => now(),
          'email_verified_at' => now()
        ],
        [
          'name' => 'Jane Doe',
          'email' => 'jane.doe@example.com',
          'admin' => false,
          'password' => Hash::make('user1234'),
          'created_at' => now(),
          'email_verified_at' => now()
        ],
        [
          'name'  => 'John Doe',
          'email' => 'john.doe@example.com',
          'admin' => true,
          'password'   => Hash::make('admin1234'),
          'created_at' => now(),
          'email_verified_at' => now()
        ]
      ]
    );
    
    // Add 40 dummy users inside a loop
    for ($i = 0; $i <= 40; $i++) {
      DB::table('users')->insert(
        [
          'name'  => "ITF User $i",
          'email' => "itf_user_$i@mailinator.com",
          'password'   => Hash::make("itfuser$i"),
          'created_at' => now(),
          'email_verified_at' => now()
        ]
      );
    }
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}