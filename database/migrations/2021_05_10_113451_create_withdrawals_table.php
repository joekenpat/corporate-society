<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('withdrawals', function (Blueprint $table) {
      $table->id();
      $table->string('code', 8)->unique();
      $table->unsignedBigInteger('user_id');
      $table->decimal('amount', 14, 2);
      $table->string('status');
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
    Schema::dropIfExists('withdrawals');
  }
}
