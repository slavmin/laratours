<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourConstructorTypesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('tour_constructor_types')->insert([
      'name'      => 'Подробный',
    ]);

    DB::table('tour_constructor_types')->insert([
      'name'      => 'Тур от партнёра',
    ]);
  }
}
