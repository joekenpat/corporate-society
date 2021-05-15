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
      $table->string('code', 8)->unique();
      $table->string('state_code',2)->nullable()->default(null);
      $table->unsignedBigInteger('lga_id')->nullable()->default(null);
      $table->decimal('available_balance', 14, 2)->default(0);
      $table->decimal('investment_balance', 14, 2)->default(0);
      $table->string('phone', 11)->unique();
      $table->enum('gender', ['M', "F"])->nullable()->default(null);
      $table->string('status')->default('pending');
      $table->string('email')->unique();
      $table->string('first_name');
      $table->string('last_name');
      $table->string('middle_name')->nullable()->default(null);
      $table->string('marital_status')->nullable()->default(null);
      $table->string('disability')->default('none');
      $table->string('identification_type')->nullable()->default(null);
      $table->string('employment_status')->nullable()->default(null);
      $table->string('profile_image')->nullable()->default(null);
      $table->string('identification_image')->nullable()->default(null);
      $table->string('address1')->nullable()->default(null);
      $table->string('address2')->nullable()->default(null);
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
