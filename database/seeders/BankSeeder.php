<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $banks_data = [
      [
        'name' => 'ACCESS BANK PLC',
        'code' => 'ABNG'
      ],
      [
        'name' => 'CITIBANK NIGERIA LIMITED',
        'code' => 'CITI'
      ],
      [
        'name' => 'DIAMOND BANK PLC',
        'code' => 'DBLN'
      ],
      [
        'name' => 'ECOBANK NIGERIA PLC',
        'code' => 'ECOC'
      ],
      [
        'name' => 'FIRST BANK OF NIGERIA LTD',
        'code' => 'FBNI'
      ],
      [
        'name' => 'FIRST CITY MONUMENT BANK',
        'code' => 'FCMB'
      ],
      [
        'name' => 'GUARANTY TRUST BANK PLC',
        'code' => 'GTBI'
      ],
      [
        'name' => 'HERITAGE BANKING COMPANY LIMITED',
        'code' => 'HBCL'
      ],
      [
        'name' => 'KEYSTONE BANK LIMITED',
        'code' => 'PLNI'
      ],
      [
        'name' => 'SKYE BANK PLC',
        'code' => 'PRDT'
      ],
      [
        'name' => 'STANBIC IBTC BANK PLC',
        'code' => 'SBIC'
      ],
      [
        'name' => 'STANDARD CHARTERED BANK NIGERIA LIMITED',
        'code' => 'SCBL'
      ],
      [
        'name' => 'STERLING BANK PLC',
        'code' => 'SBPL'
      ],
      [
        'name' => 'UNION BANK OF NIGERIA PLC',
        'code' => 'UBNI'
      ],
      [
        'name' => 'UNITED BANK FOR AFRICA PLC',
        'code' => 'UNAF'
      ],
      [
        'name' => 'UNITY BANK PLC',
        'code' => 'ICIT'
      ],
      [
        'name' => 'WEMA BANK PLC',
        'code' => 'WEMA'
      ],
      [
        'name' => 'ZENITH BANK PLC',
        'code' => 'ZEIB'
      ],
    ];
    $bank_count = count($banks_data);
    $bankProgressBar = $this->command->getOutput()->createProgressBar($bank_count);
    foreach ($banks_data as $bank) {
      DB::table('banks')->insert($bank);
      $bankProgressBar->advance();
    }
    $bankProgressBar->finish();
  }
}
