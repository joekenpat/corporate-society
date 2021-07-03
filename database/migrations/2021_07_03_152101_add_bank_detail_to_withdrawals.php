<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankDetailToWithdrawals extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('withdrawals', function (Blueprint $table) {
      $table->string('account_name')->after('status')->nullable()->default(null);
      $table->string('account_number', 15)->after('status')->nullable()->default(null);
      $table->string('bank_code', 10)->after('status')->nullable()->default(null);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('withdrawals', function (Blueprint $table) {
      $table->dropColumn([
        'account_name',
        'account_number',
        'bank_code'
      ]);
    });
  }
}
