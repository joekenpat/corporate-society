<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNextOfKinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('state_id')->nullable()->default(null);
            $table->unsignedBigInteger('lga_id')->nullable()->default(null);
            $table->string('phone', 11)->unique();
            $table->string('gender');
            $table->string('status')->default('pending');
            $table->string('email')->unique();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('middleName')->nullable()->default(null);
            $table->string('maritalStatus');
            $table->string('disability')->default('none');
            $table->string('identificationType');
            $table->string('employmentStatus');
            $table->string('profileImage')->nullable()->default(null);
            $table->string('identificationImage')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->timestamp('dob')->nullable()->default(null);
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
        Schema::dropIfExists('next_of_kin');
    }
}
