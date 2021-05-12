<?php

namespace database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Admin::create([
      'first_name' => 'Test',
      'last_name' => 'One',
      'email' => 'test1@test.com',
      'password' => Hash::make('1234'),
    ]);
    Admin::create([
      'first_name' => 'Test',
      'last_name' => 'Two',
      'email' => 'test2@test.com',
      'password' => Hash::make('1234'),
    ]);
  }
}
