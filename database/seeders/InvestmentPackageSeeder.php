<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvestmentPackageSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $investmentPackagesData = [

      [
        'name' => 'FINANCIAL INVESTMENT PACKAGE',
        'min_amount' => 50000,
        'max_amount' => 2000000,
        'duration' => 2,
        'active' => true,
        'roi_percent' => 32.2
      ],
      [
        'name' => 'PROPERTY ACQUISITION PACKAGE',
        'min_amount' => 50000,
        'max_amount' => 2000000,
        'duration' => 2,
        'active' => true,
        'roi_percent' => 32.2
      ],
      [
        'name' => 'FAMILY PLAN PACKAGE',
        'min_amount' => 50000,
        'max_amount' => 2000000,
        'duration' => 2,
        'active' => true,
        'roi_percent' => 32.2
      ],
      [
        'name' => 'AGRICULTURAL INVESTMENT PACKAGE',
        'min_amount' => 50000,
        'max_amount' => 2000000,
        'duration' => 2,
        'active' => true,
        'roi_percent' => 32.2
      ],
      [
        'name' => 'HEALTH AND EDUCATION PACKAGE',
        'min_amount' => 50000,
        'max_amount' => 2000000,
        'duration' => 2,
        'active' => true,
        'roi_percent' => 32.2
      ],
      [
        'name' => 'SKILL ACQUISITION PACKAGE',
        'min_amount' => 50000,
        'max_amount' => 2000000,
        'duration' => 2,
        'active' => true,
        'roi_percent' => 32.2
      ],
    ];
    $investmentPackagesDataCount = count($investmentPackagesData);
    $investmentPackageProgressBar = $this->command->getOutput()->createProgressBar($investmentPackagesDataCount);
    foreach ($investmentPackagesData as $bank) {
      $bank = [];
      $investmentPackageProgressBar->advance();
    }
    DB::table('investment_packages')->insert($investmentPackagesData);
    $investmentPackageProgressBar->finish();
  }
}
