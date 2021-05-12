<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StateSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $states_data = [
      'FC' => 'Abuja',
      'AB' => 'Abia',
      'AD' => 'Adamawa',
      'AK' => 'Akwa Ibom',
      'AN' => 'Anambra',
      'BA' => 'Bauchi',
      'BY' => 'Bayelsa',
      'BE' => 'Benue',
      'BO' => 'Borno',
      'CR' => 'Cross River',
      'DE' => 'Delta',
      'EB' => 'Ebonyi',
      'ED' => 'Edo',
      'EK' => 'Ekiti',
      'EN' => 'Enugu',
      'GO' => 'Gombe',
      'IM' => 'Imo',
      'JI' => 'Jigawa',
      'KD' => 'Kaduna',
      'KN' => 'Kano',
      'KT' => 'Katsina',
      'KE' => 'Kebbi',
      'KO' => 'Kogi',
      'KW' => 'Kwara',
      'LA' => 'Lagos',
      'NA' => 'Nasarawa',
      'NI' => 'Niger',
      'OG' => 'Ogun',
      'ON' => 'Ondo',
      'OS' => 'Osun',
      'OY' => 'Oyo',
      'PL' => 'Plateau',
      'RI' => 'Rivers',
      'SO' => 'Sokoto',
      'TA' => 'Taraba',
      'YO' => 'Yobe',
      'ZA' => 'Zamfara',
    ];
    $states_count = count($states_data);
    $stateProgressBar = $this->command->getOutput()->createProgressBar($states_count);
    foreach ($states_data as $state_code => $state_data) {
      $state = [
        'name' => $state_data,
        'code' => $state_code,
      ];
      DB::table('states')->insert($state);
      $state = [];
      $stateProgressBar->advance();
    }
    $stateProgressBar->finish();
  }
}
