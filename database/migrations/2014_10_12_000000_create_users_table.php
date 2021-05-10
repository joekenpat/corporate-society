<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('code', 7)->unique();
      $table->unsignedBigInteger('membership_package_id')->nullable()->default(null);
      $table->unsignedBigInteger('state_id')->nullable()->default(null);
      $table->unsignedBigInteger('lga_id')->nullable()->default(null);
      $table->string('phone', 11)->unique();
      $table->enum('gender', ['M', "F"])->nullable()->default(null);
      $table->string('status')->default('pending');
      $table->string('email')->unique();
      $table->string('first_name');
      $table->string('last_name');
      $table->string('middle_name')->nullable()->default(null);
      $table->string('marital_status');
      $table->string('disability')->default('none');
      $table->string('identification_type');
      $table->string('employment_status');
      $table->string('profileImage')->nullable()->default(null);
      $table->string('identification_image')->nullable()->default(null);
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->dateTime('dob')->nullable()->default(null);
      $table->rememberToken();
      $table->timestamps();
    });
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