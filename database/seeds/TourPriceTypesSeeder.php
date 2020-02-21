<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TourPriceTypesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('tour_price_types')->insert([
      'name'      => 'За час',
      'value'     => 'hour',
    ]);

    DB::table('tour_price_types')->insert([
      'name'      => 'За сутки',
      'value'     => 'day',
    ]);

    DB::table('tour_price_types')->insert([
      'name'      => 'Разово',
      'value'     => 'instant',
    ]);
  }
}
