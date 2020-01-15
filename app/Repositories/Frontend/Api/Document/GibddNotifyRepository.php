<?php

namespace App\Repositories\Frontend\Api\Document;

use App\Models\Auth\Team;
use App\Models\Tour\Tour;

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
      "Наименование инициатора перевозки: "
      . $this->getCompanyInfo(auth()->user()->current_team_id)
      . "<br />";

    $result = $result .
      "Наименование организатора перевозки:"
      . $this->getCompanyInfo(auth()->user()->current_team_id)
      . "<br />";

    $result = $result .
      "Наименование и адрес заказчика автобуса:"
      . $this->getCompanyInfo(auth()->user()->current_team_id)
      . "<br />";

    $result = $result .
      "Наименование и адрес перевозчика:"
      . $this->getTransportCompanyInfo()
      . "<br />";
    //dd($tour_options);
    $result = $result .
      "Дата перевозки: "
      . $this->tour_options->options->dateStart
      . "<br />";


    $result = $result .
      "Марка и регистрационный знак автобуса: "
      . $this->getBusInfo($this->tour)
      . "<br />";

    $result = $result .
      "Наименование владельца автобуса: "
      . $this->getTransportCompanyInfo()
      . "<br />";

    $result = $result .
      "ФИО водителя: "
      . $this->getDriversInfo()
      . "<br />";

    $result = $result .
      "<br />"
      . "Подпись лица, ответственного за организацию перевозки <br />"
      . "_______________________";

    return $result;
  }

  /**
   * Возвращает массив адресов музеев.
   * Принимает id тура.
   * 
   * @param @tour_id
   */

  public function getMuseumAdresses($tour_id)
  {
    $this->tour = Tour::where('id', $tour_id)->first();
    $this->tour_options = json_decode($this->tour->extra);


    $result = [];
    foreach ($this->tour_options->museum as $museum) {
      // dd($driver);
      if (json_decode($museum->museum->extra)->address) {
        array_push($result, json_decode($museum->museum->extra)->address);
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
    $result = '';
    $number = 1;
    $tour_transport = $this->tour_options->transport;

    foreach ($tour_transport as $transport) {
      $bus = $transport->obj;
      $bus_details = json_decode($bus->extra);

      $has_glonass = $bus_details->busDocs->glonass;
      $has_era_glonass = $bus_details->busDocs->eraGlonass;

      $result = $result
        . "<br />"
        . "$number. Марка, модель: "
        . $bus->name . ", "
        . "гос. номер: "
        . $bus_details->busDocs->regNumber . ". "
        . $bus->description . ". "
        . "Номер диагностической карты и срок ее действия: "
        . $bus_details->busDocs->diagCard . ". ";

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
      $drivers = json_decode($bus->extra)->drivers;

      foreach ($drivers as $driver) {
        // dd($driver);
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
    }

    return $result;
  }
}
