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
        'name' => 'Abbey Mortgage Bank',
        'code' => '801',
      ],
      [
        'name' => 'Access Bank',
        'code' => '044',
      ],
      [
        'name' => 'Access Bank (Diamond)',
        'code' => '063',
      ],
      [
        'name' => 'ALAT by WEMA',
        'code' => '035A',
      ],
      [
        'name' => 'ASO Savings and Loans',
        'code' => '401',
      ],
      [
        'name' => 'Bowen Microfinance Bank',
        'code' => '50931',
      ],
      [
        'name' => 'CEMCS Microfinance Bank',
        'code' => '50823',
      ],
      [
        'name' => 'Citibank Nigeria',
        'code' => '023',
      ],
      [
        'name' => 'Coronation Merchant Bank',
        'code' => '559',
      ],
      [
        'name' => 'Ecobank Nigeria',
        'code' => '050',
      ],
      [
        'name' => 'Ekondo Microfinance Bank',
        'code' => '562',
      ],
      [
        'name' => 'Eyowo',
        'code' => '50126',
      ],
      [
        'name' => 'Fidelity Bank',
        'code' => '070',
      ],
      [
        'name' => 'First Bank of Nigeria',
        'code' => '011',
      ],
      [
        'name' => 'First City Monument Bank',
        'code' => '214',
      ],
      [
        'name' => 'FSDH Merchant Bank Limited',
        'code' => '501',
      ],
      [
        'name' => 'Globus Bank',
        'code' => '00103',
      ],
      [
        'name' => 'Guaranty Trust Bank',
        'code' => '058',
      ],
      [
        'name' => 'Hackman Microfinance Bank',
        'code' => '51251',
      ],
      [
        'name' => 'Hasal Microfinance Bank',
        'code' => '50383',
      ],
      [
        'name' => 'Heritage Bank',
        'code' => '030',
      ],
      [
        'name' => 'Ibile Microfinance Bank',
        'code' => '51244',
      ],
      [
        'name' => 'Infinity MFB',
        'code' => '50457',
      ],
      [
        'name' => 'Jaiz Bank',
        'code' => '301',
      ],
      [
        'name' => 'Keystone Bank',
        'code' => '082',
      ],
      [
        'name' => 'Kuda Bank',
        'code' => '50211',
      ],
      [
        'name' => 'Lagos Building Investment Company Plc.',
        'code' => '90052',
      ],
      [
        'name' => 'Mayfair MFB',
        'code' => '50563',
      ],
      [
        'name' => 'One Finance',
        'code' => '565',
      ],
      [
        'name' => 'PalmPay',
        'code' => '999991',
      ],
      [
        'name' => 'Parallex Bank',
        'code' => '526',
      ],
      [
        'name' => 'Parkway - ReadyCash',
        'code' => '311',
      ],
      [
        'name' => 'Paycom',
        'code' => '999992',
      ],
      [
        'name' => 'Petra Mircofinance Bank Plc',
        'code' => '50746',
      ],
      [
        'name' => 'Polaris Bank',
        'code' => '076',
      ],
      [
        'name' => 'Providus Bank',
        'code' => '101',
      ],
      [
        'name' => 'Rand Merchant Bank',
        'code' => '502',
      ],
      [
        'name' => 'Rubies MFB',
        'code' => '125',
      ],
      [
        'name' => 'Sparkle Microfinance Bank',
        'code' => '51310',
      ],
      [
        'name' => 'Stanbic IBTC Bank',
        'code' => '221',
      ],
      [
        'name' => 'Standard Chartered Bank',
        'code' => '068',
      ],
      [
        'name' => 'Sterling Bank',
        'code' => '232',
      ],
      [
        'name' => 'Suntrust Bank',
        'code' => '100',
      ],
      [
        'name' => 'TAJ Bank',
        'code' => '302',
      ],
      [
        'name' => 'TCF MFB',
        'code' => '51211',
      ],
      [
        'name' => 'Titan Bank',
        'code' => '102',
      ],
      [
        'name' => 'Union Bank of Nigeria',
        'code' => '032',
      ],
      [
        'name' => 'United Bank For Africa',
        'code' => '033',
      ],
      [
        'name' => 'Unity Bank',
        'code' => '215',
      ],
      [
        'name' => 'VFD Microfinance Bank Limited',
        'code' => '566',
      ], [
        'name' => 'Wema Bank',
        'code' => '035',
      ],
      [
        'name' => 'Zenith Bank',
        'code' => '057',
      ],
    ];
    $bank_count = count($banks_data);
    $bankProgressBar = $this->command->getOutput()->createProgressBar($bank_count);
    foreach ($banks_data as $bank) {
      $bank = [];
      $bankProgressBar->advance();
    }
    DB::table('banks')->insert($banks_data);
    $bankProgressBar->finish();
  }
}
