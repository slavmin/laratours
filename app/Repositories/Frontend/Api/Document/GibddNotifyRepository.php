<?php

namespace App\Repositories\Frontend\Api\Document;

use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourCity;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourTransport;
use Carbon\Carbon;

/**
 *  Class DocumentRepository
 * 
 *  @package App\Repositories
 */
class GibddNotifyRepository
{

  /**
   * @var tour
   */
  private $tour;
  private $tour_options;

  /**
   * Возвращает html строку уведомления в ГИБДД.
   * Принимает id тура.
   * 
   * @param @tour_id
   */

  public function getTextForTour($tour_id)
  {
    $this->tour = Tour::where('id', $tour_id)->first();
    $this->tour_options = json_decode($this->tour->extra);

    $result = '';

    $header = $this->getHeader();
    $result = $result . $header;

    $result = $result .
      "<h2>Наименование инициатора перевозки:</h2>"
      . $this->getCompanyInfo(auth()->user()->current_team_id)
      . "<br />";

    $result = $result .
      "<h2>Наименование организатора перевозки:</h2>"
      . $this->getCompanyInfo(auth()->user()->current_team_id)
      . "<br />";

    $result = $result .
      "<h2>Наименование и адрес заказчика автобуса:</h2>"
      . $this->getCompanyInfo(auth()->user()->current_team_id)
      . "<br />";

    $result = $result .
      "<h2>Наименование и адрес перевозчика:</h2>"
      . $this->getTransportCompanyInfo()
      . "<br />";
    //dd($tour_options);
    $result = $result .
      "<h2>Дата перевозки:</h2>"
      . ((new Carbon($this->tour_options->options->dateStart))->toDateString())
      . "<br />";


    $result = $result .
      "<h2>Марка и регистрационный знак автобуса:</h2>"
      . $this->getBusInfo($this->tour)
      . "<br />";

    $result = $result .
      "<h2>Наименование владельца автобуса:</h2>"
      . $this->getTransportCompanyInfo()
      . "<br />";

    $result = $result .
      "<h2>ФИО водителя:</h2>"
      . $this->getDriversInfo()
      . "<br />";

    $result = $result .
      "<br />"
      . "<h3>Подпись лица, ответственного за организацию перевозки</h3><br />"
      . "_______________________/_______________________";

    return $result;
  }

  /**
   * Возвращает массив адресов музеев, размещений и мест питания
   * с разбивкой по дням. В нулевой индекс массива заносятся объекты
   * у которых не указаны дни в конструкторе тура.
   * Принимает id тура.
   * 
   * @param @tour_id
   */

  public function getTourAddresses($tour_id)
  {
    $this->tour = Tour::where('id', $tour_id)->first();
    $this->tour_options = json_decode($this->tour->extra);

    $transport_days = $this->getTourTransportDays($tour_id);

    // Calculate tour length in days
    $tour_days_count = $this->tour_options->options->days;
    $tour_nights_count = $this->tour_options->options->nights;
    $tour_length = $tour_days_count >= $tour_nights_count
      ? $tour_days_count
      : $tour_nights_count;

    // Create result array
    $result = [];
    for ($day = 0; $day <= $tour_length; $day++) {
      $result[$day] = [];
    }

    // Add museums
    foreach ($this->tour_options->museum as $museum) {

      if (property_exists($museum->obj, 'day')) {
        $museum_day = $museum->obj->day;
      }
      if (in_array($museum_day, $transport_days)) {
        $museum_data = [
          'name'    => $museum->museum->name,
          'event'   => $museum->obj->name,
        ];
        if (property_exists(json_decode($museum->museum->extra), 'address')) {
          $museum_data['address'] = json_decode($museum->museum->extra)->address;
        } else {
          $museum_data['address'] = 'Адрес не указан';
        }
        array_push($result[$museum_day], $museum_data);
      }
    }

    // Add hotels
    foreach ($this->tour_options->hotel as $hotel) {
      $hotel_data = [
        'name'    => $hotel->hotel->name,
        'event'   => $hotel->obj->name,
      ];
      if (property_exists(json_decode($hotel->hotel->extra), 'address')) {
        $hotel_data['address'] = json_decode($hotel->hotel->extra)->address;
      } else {
        $hotel_data['address'] = 'Адрес не указан';
      }

      if (property_exists($hotel->obj, 'daysArray')) {
        foreach ($hotel->obj->daysArray as $hotel_day) {
          if (in_array($hotel_day, $transport_days)) {
            array_push($result[$hotel_day], $hotel_data);
          }
        }
      }
    }

    // Add meals
    foreach ($this->tour_options->meal as $meal) {
      $meal_data = [
        'name'    => $meal->meal->name,
        'event'   => $meal->obj->name,
      ];
      if (property_exists(json_decode($meal->meal->extra), 'address')) {
        $meal_data['address'] = json_decode($meal->meal->extra)->address;
      } else {
        $meal_data['address'] = 'Адрес не указан';
      }

      if (property_exists($meal->obj, 'daysArray')) {
        foreach ($meal->obj->daysArray as $meal_day) {
          if (in_array($meal_day, $transport_days)) {
            array_push($result[$meal_day], $meal_data);
          }
        }
      }
    }

    foreach ($result as $key => $value) {
      if (!count($value)) {
        unset($result[$key]);
      }
    }

    return collect($result);
  }

  /**
   * Возвращает массив дней в которых учавствует транспорт
   * 
   * @param @tour_id
   */
  public function getTourTransportDays($tour_id)
  {
    $this->tour = Tour::where('id', $tour_id)->first();
    $this->tour_options = json_decode($this->tour->extra);

    $result = [];

    foreach ($this->tour_options->transport as $transport) {
      $transport_days = $transport->obj->daysArray;
      foreach ($transport_days as $transport_day) {
        if (!in_array($transport_day, $result)) {
          array_push($result, $transport_day);
        }
      }
    }

    return $result;
  }

  /**
   * Возвращает массив данных для заполнения уведомления в ГИБДД
   * о перевозке детей.
   * 
   * @param @tour_id
   */
  public function getDataForGibddNotify($tour_id, $tour_day)
  {
    $this->tour = Tour::where('id', $tour_id)->first();
    $this->tour_options = json_decode($this->tour->extra);

    $team = Team::findOrFail(auth()->user()->current_team_id);
    $team_profile = $team->getProfilesAttribute()['formal'];

    $cities_array = $this->tour->cities_list;
    $selected_region_codes = [];
    foreach ($cities_array as $city_id) {
      $city_name = TourCity::find($city_id)->name;
      $region_code = $this->getRegionCodeByName($city_name);
      if ($region_code) {
        array_push($selected_region_codes, $region_code);
      }
    }

    $form1 = [
      'name' => $team_profile['company_ceo_name'] ?? '',
      'position' => 'Генеральный директор',
      'phone' => $team_profile['company_phone'] ?? '',
      'email' => $team_profile['company_email'] ?? '',
      'selectedRegionCodes' => $selected_region_codes,
      'count' => $this->tour_options->qnt ?? '',
      'goal' => '',
      'dateStart' => substr($this->tour_options->options->dateStart, 0, 10),
      'timeStart' => substr($this->tour_options->options->dateStart, 10),
      'dateEnd' => '',
      'timeEnd' => '',
    ];

    $form2 = [
      'type' => '2',
      'entity_name' => $team_profile['company_full_name'] ?? '',
      'name' => '',
      'entity_address' => $team_profile['company_address'] ?? '',
      'address' => '',
      'entity_location' => $team_profile['company_real_address'] ?? '',
      'phone' => $team_profile['company_phone'] ?? '',
      'email' => $team_profile['company_email'] ?? '',
      'inn' => $team_profile['company_inn'] ?? '',
    ];

    $tour_transport_company = [];
    $tour_transport_bus = [];

    foreach ($this->tour_options->transport as $transport) {
      if (in_array($tour_day, $transport->obj->daysArray)) {
        $tour_transport_company = TourTransport::findOrFail($transport->transport->id);
        $tour_transport_company_extra = json_decode($tour_transport_company->description);
        $tour_transport_bus = TourObjectAttributes::findOrFail($transport->obj->id);
      }
    }

    $form3 = [
      'type' => '2',
      'entity_name' => $tour_transport_company->name ?? '',
      'name' => '',
      'entity_address' => $tour_transport_company_extra->address ?? '',
      'address' => '',
      'entity_location' => $tour_transport_company_extra->address ?? '',
      'phone' => $tour_transport_company_extra->contacts->phone ?? '',
      'email' => $tour_transport_company_extra->contacts->email ?? '',
      'inn' => '',
    ];

    $tour_transport_bus_extra = json_decode(($tour_transport_bus->extra));
    $form4 = [
      'vehicles' => [
        [
          'brand_and_model' => $tour_transport_bus->name ?? '',
          'number' => $tour_transport_bus_extra->busDocs->regNumber ?? '',
          'diagnostic_card_info' => $tour_transport_bus_extra->busDocs->diagCard ?? '',
          'navigator_info' => $tour_transport_bus_extra->busDocs->glonass ?? 1,
        ],
      ]
    ];

    $form5 = [
      'drivers' => []
    ];
    foreach ($tour_transport_bus_extra->drivers as $driver) {
      array_push($form5['drivers'], [
        'name' => $driver->name ?? '',
        'licence' => $driver->license ?? '',
        'licence_date' => '01.01.2000',
        'experience' => $driver->exp ?? '',
      ]);
    }

    $form6 = [
      'address_start' => '',
      'region_code' => '',
      'district' => '',
      'distance' => '',
      'schedule' => '',
      'duration' => '',
      'stopPoints' => [],
    ];

    $result = [
      'tour_name' => $this->tour->name,
      'form1' => $form1,
      'form2' => $form2,
      'form3' => $form3,
      'form4' => $form4,
      'form5' => $form5,
      'form6' => $form6,
    ];

    return $result;
  }

  /**
   * Возвращает цифровой код региона России по названию
   * Содержит массив регионов России. 78 - Спб, 77 - Москва и т.д.
   * 
   * @param int
   */
  public function getRegionCodeByName($region_name)
  {
    $russian_regions = [
      "01" => "Республика Адыгея",
      "02" => "Республика Башкортостан",
      "03" => "Республика Бурятия",
      "04" => "Республика Алтай",
      "05" => "Республика Дагестан",
      "06" => "Республика Ингушетия",
      "07" => "Кабардино-Балкарская Республика",
      "08" => "Республика Калмыкия",
      "09" => "Республика Карачаево-Черкессия",
      "10" => "Республика Карелия",
      "11" => "Республика Коми",
      "12" => "Республика Марий Эл",
      "13" => "Республика Мордовия",
      "14" => "Республика Саха (Якутия)",
      "15" => "Республика Северная Осетия-Алания",
      "16" => "Республика Татарстан",
      "17" => "Республика Тыва",
      "18" => "Удмуртская Республика",
      "19" => "Республика Хакасия",
      "21" => "Чувашская Республика",
      "22" => "Алтайский край",
      "23" => "Краснодарский край",
      "24" => "Красноярский край",
      "25" => "Приморский край",
      "26" => "Ставропольский край",
      "27" => "Хабаровский край",
      "28" => "Амурская область",
      "29" => "Архангельская область",
      "30" => "Астраханская область",
      "31" => "Белгородская область",
      "32" => "Брянская область",
      "33" => "Владимирская область",
      "34" => "Волгоградская область",
      "35" => "Вологодская область",
      "36" => "Воронежская область",
      "37" => "Ивановская область",
      "38" => "Иркутская область",
      "39" => "Калининградская область",
      "40" => "Калужская область",
      "41" => "Камчатский край",
      "42" => "Кемеровская область - Кузбасс",
      "43" => "Кировская область",
      "44" => "Костромская область",
      "45" => "Курганская область",
      "46" => "Курская область",
      "47" => "Ленинградская область",
      "48" => "Липецкая область",
      "49" => "Магаданская область",
      "50" => "Московская область",
      "51" => "Мурманская область",
      "52" => "Нижегородская область",
      "53" => "Новгородская область",
      "54" => "Новосибирская область",
      "55" => "Омская область",
      "56" => "Оренбургская область",
      "57" => "Орловская область",
      "58" => "Пензенская область",
      "59" => "Пермский край",
      "60" => "Псковская область",
      "61" => "Ростовская область",
      "62" => "Рязанская область",
      "63" => "Самарская область",
      "64" => "Саратовская область",
      "65" => "Сахалинская область",
      "66" => "Свердловская область",
      "67" => "Смоленская область",
      "68" => "Тамбовская область",
      "69" => "Тверская область",
      "70" => "Томская область",
      "71" => "Тульская область",
      "72" => "Тюменская область",
      "73" => "Ульяновская область",
      "74" => "Челябинская область",
      "75" => "Забайкальский край",
      "76" => "Ярославская область",
      "77" => "Москва",
      "78" => "Санкт-Петербург",
      "79" => "Еврейская автономная область",
      "82" => "Республика Крым",
      "83" => "Ненецкий автономный округ",
      "86" => "Ханты-Мансийский автономный округ - Югра",
      "87" => "Чукотский автономный округ",
      "89" => "Ямало-Ненецкий автономный округ",
      "92" => "Севастополь",
      "95" => "Чеченская Республика",
    ];

    $result = array_search($region_name, $russian_regions);
    if ($result) {
      return $result;
    }
  }

  public function getHeader()
  {
    return "<h1>УВЕДОМЛЕНИЕ ОБ ОРГАНИЗОВАННОЙ ПЕРЕВОЗКЕ ДЕТЕЙ АВТОБУСОМ</h1>";
  }

  public function getCompanyInfo($company_id)
  {
    $result = '';
    $company = Team::where('id', $company_id)->first();
    $company_profile = $company
      ->profiles()
      ->where(['type' => 'formal'])
      ->get()
      ->pluck('content')[0];

    // dd($company_profile);
    $result = $result
      . $company_profile['company_full_name'] . ", "
      . $company_profile['company_bankaccount'] . ", "
      . $company_profile['company_bankname'] . ", "
      . $company_profile['company_bankcorr'] . ", "
      . $company_profile['company_ceo_name'] . ", "
      . "ИНН: "
      . $company_profile['company_inn'] . "/"
      . "КПП: "
      . $company_profile['company_kpp'] . ". "
      . "Юридический адрес: "
      . $company_profile['company_address'] . ". "
      . "Фактический адрес: "
      . $company_profile['company_real_address'] . ". "
      . $company_profile['company_phone'] . ". ";

    return $result;
  }

  public function getTransportCompanyInfo()
  {
    $result = '';
    $tour_transport = $this->tour_options->transport;

    foreach ($tour_transport as $transport) {
      $company = $transport->transport;
      $company_details = json_decode($company->description);

      $result = $result
        . $company->name . ", "
        . "Адрес: "
        . $company_details->address . ". ";

      $result = $result
        . "Дополнительно: "
        . $company_details->about . ". ";

      // if (!$company_details->about != '')
      // {
      //   $result = $result
      //     ."Дополнительно: "
      //     .$company_details->about.". ";
      // }
    }

    return $result;
  }

  public function getBusInfo()
  {
    $empty_entry = 'Поле не заполнено';
    $result = '';
    $number = 1;
    $tour_transport = $this->tour_options->transport;

    foreach ($tour_transport as $transport) {
      $bus = $transport->obj;
      $bus_details = json_decode($bus->extra);
      if (property_exists($bus_details, 'busDocs')) {
        $has_glonass = $bus_details->busDocs->glonass;
        $has_era_glonass = $bus_details->busDocs->eraGlonass;
        $reg_number = $bus_details->busDocs->regNumber;
        $diag_card = $bus_details->busDocs->diagCard;
      } else {
        $has_glonass = false;
        $has_era_glonass = false;
        $reg_number = $empty_entry;
        $diag_card = $empty_entry;
      }


      $result = $result
        . "<br />"
        . "$number. Марка, модель: "
        . $bus->name . ", "
        . "гос. номер: "
        . $reg_number . ". "
        . $bus->description . ". "
        . "Номер диагностической карты и срок ее действия: "
        . $diag_card . ". ";

      if ($has_glonass) $result = $result . "Глонасс. ";
      if ($has_era_glonass) $result = $result . "Эра-глонасс. ";

      $number++;
    }

    return $result;
  }

  public function getDriversInfo()
  {
    $result = '';
    $number = 1;
    $tour_transport = $this->tour_options->transport;

    foreach ($tour_transport as $transport) {
      $bus = $transport->obj;

      if (property_exists(json_decode($bus->extra), 'drivers')) {
        $drivers = json_decode($bus->extra)->drivers;

        foreach ($drivers as $driver) {
          $result = $result
            . "<br />"
            . $number . ". "
            . $driver->name . ", "
            . "водительское удостоверение "
            . $driver->license . ", "
            . "стаж водителем автобуса в категории «Д»: "
            . $driver->exp . " лет.";
          $number++;
        }
      } else {
        $result = "Автобус: " . $bus->name . ". Данные по водителям не заполнены!";
      }
    }

    return $result;
  }
}
