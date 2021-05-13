<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call([
      StateSeeder::class,
      LgaSeeder::class,
      AdminSeeder::class,
      BankSeeder::class,
      InvestmentPackageSeeder::class,
    ]);
  }
}
