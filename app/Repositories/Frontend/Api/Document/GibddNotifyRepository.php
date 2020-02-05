<?php

namespace App\Repositories\Frontend\Api\Document;

use App\Models\Auth\Team;
use App\Models\Tour\Tour;
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
