<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentPackagesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('investment_packages', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->integer('min_amount')->default(100000);
      $table->integer('max_amount')->default(2000000);
      $table->integer('duration')->default(7);
      $table->boolean('active')->default(true);
      $table->decimal('roi_percent', 4, 2);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('investment_packages');
  }
}
