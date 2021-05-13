<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('investments', function (Blueprint $table) {
      $table->id();
      $table->string('code', 8)->unique();
      $table->unsignedBigInteger('user_id');
      $table->string('package_name');
      $table->decimal('amount', 14, 2);
      $table->decimal('roi', 14, 2);
      $table->timestamp('ends_at')->nullable()->default(null);
      $table->timestamp('completed_at')->nullable()->default(null);
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
    Schema::dropIfExists('investments');
  }
}
