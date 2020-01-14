<?php

namespace App\Http\Controllers\Frontend\Demo;

use App\Http\Controllers\Controller;
use App\Models\Tour\TourAttendant;
use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourGuide;
use App\Models\Tour\TourHotel;
use App\Models\Tour\TourHotelCategory;
use App\Models\Tour\TourObjectAttributes;
use Illuminate\Http\Request;

class DemoDataController extends Controller
{
  public function writeDemoDataToDB(Request $request)
  {
    $team_id = $request->team_id;

    $customer_types = [
      'Взрослый'      => (new TourCustomerType())->create([
        'name'        => 'Взрослый',
        'team_id'     => $team_id,
        'description' => '{"ageFrom":18,"ageTo":99,"isPens":false}',
      ]),
      'Младенец'      => (new TourCustomerType())->create([
        'name'        => 'Младенец 0-3',
        'team_id'     => $team_id,
        'description' => '{"ageFrom":0,"ageTo":2,"isPens":false}',
      ]),
      'Ребенок до 7 лет'      => (new TourCustomerType())->create([
        'name'        => 'Ребенок до 7 лет',
        'team_id'     => $team_id,
        'description' => '{"ageFrom":3,"ageTo":6,"isPens":false}',
      ]),
      'Школьник 7-18 лет'      => (new TourCustomerType())->create([
        'name'        => 'Школьник 7-18 лет',
        'team_id'     => $team_id,
        'description' => '{"ageFrom":7,"ageTo":17,"isPens":false}',
      ]),
      'Студент 18-22'      => (new TourCustomerType())->create([
        'name'        => 'Студент 18-22',
        'team_id'     => $team_id,
        'description' => '{"ageFrom":18,"ageTo":21,"isPens":false}',
      ]),
      'Иностранец'      => (new TourCustomerType())->create([
        'name'        => 'Иностранец',
        'team_id'     => $team_id,
        'description' => '',
      ]),
      'Пенсионер'      => (new TourCustomerType())->create([
        'name'        => 'Пенсионер',
        'team_id'     => $team_id,
        'description' => '{"isPens":true,"agePensMale":60,"agePensFemale":55}',
      ]),
    ];

    $hotel_categories = [
      'standart'    => (new TourHotelCategory())->create([
        'name'        => 'standart',
        'team_id'     => $team_id,
        'description' => 'Стандарт',
      ]),
      'lux'    => (new TourHotelCategory())->create([
        'name'        => 'lux',
        'team_id'     => $team_id,
        'description' => 'Люкс',
      ]),
      'studio'    => (new TourHotelCategory())->create([
        'name'        => 'studio',
        'team_id'     => $team_id,
        'description' => 'Студия',
      ])
    ];

    $hotels = [
      'Отель 3*'  => (new TourHotel())->create([
        'name'     => 'Отель 3*',
        'team_id'  => $team_id,
        'city_id'  => 2,
        'extra'    => '{"hotelType":["3*"],"address":"","about":"","contacts":{"site":"http://","email":"","phone":"+7"},"staff":{"name":"","phone":"+7-"}}',
      ]),
      'Отель на Невском '  => (new TourHotel())->create([
        'name'     => 'Отель на Невском ',
        'team_id'  => $team_id,
        'city_id'  => 2,
        'extra'    => '{"hotelType":[],"address":"","about":"","contacts":{"site":"http://","email":"","phone":"+7"},"staff":{"name":"","phone":"+7-"}}',
      ]),
    ];

    $hotels['Отель 3*']->objectables()->updateOrCreate(
      ['id' => 0],
      [
        'name' => 'Двухместный номер',
        'qnt' => 10,
        'description' => null,
        'price' => null,
        'extra' => '{"priceList":{"adl":{"std":2000,"sngl":1500,"extra":1200},"chd":{"age":7,"std":1400,"extra":900},"inf":{"age":2,"std":0,"isFree":true}}}',
        'customer_type_id' => 1,
      ]
    );

    $hotels['Отель на Невском ']->objectables()->updateOrCreate(
      ['id' => 0],
      [
        'name' => 'Стандарт',
        'qnt' => 5,
        'description' => null,
        'price' => null,
        'extra' => '{"priceList":{"adl":{"std":2500,"sngl":2800,"extra":1500},"chd":{"age":7,"std":800,"extra":0},"inf":{"age":2,"std":0,"isFree":true}}}',
        'customer_type_id' => 1,
      ]
    );

    $guide = (new TourGuide())->create([
      'name'        => 'Всезнайкин Егор Тимофеевич',
      'team_id'     => $team_id,
      'price'       => 1500,
      'description' => '{"city":2,"address":"Санкт-Петербург Дворцовая набережная, 34","about":"","grade":["Стандарт","VIP"],"languages":[],"contacts":{"email":"","phone":"+7-911-555-12-24","secretPhone":"+7-962-315-55-44"}}',
      'extra'       => '{"city":2,"address":"Санкт-Петербург Дворцовая набережная, 34","about":"","grade":["Стандарт","VIP"],"languages":[],"contacts":{"email":"","phone":"+7-911-555-12-24","secretPhone":"+7-962-315-55-44"}}',
    ]);

    $attendant = (new TourAttendant())->create([
      'name'        => 'Сопроводилова Оксана Георгиевна',
      'team_id'     => $team_id,
      'price'       => 1000,
      'description' => '{"city":2,"address":"Санкт-Петербург Дворцовая набережная, 34","about":"","grade":["Стандарт","VIP"],"languages":[],"contacts":{"email":"","phone":"+7-911-333-12-20","secretPhone":"+7-962-231-55-11"}}',
      'extra'       => '{"city":2,"address":"Санкт-Петербург Дворцовая набережная, 34","about":"","grade":["Стандарт","VIP"],"languages":[],"contacts":{"email":"","phone":"+7-911-333-12-20","secretPhone":"+7-962-231-55-11"}}',
    ]);

    $data = [
      'method'            => __METHOD__,
      'params'            => $request->all(),
      'team_id'           => $team_id,
      'customer_types'    => $customer_types,
      'hotel_categories'  => $hotel_categories,
      'hotels'            => $hotels,
      'guide'             => $guide,
      'attendant'         => $attendant,
    ];
    if ($request->expectsJson()) {
      return response()->json($data);
    }
  }
}
