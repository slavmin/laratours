<?php

namespace App\Repositories\Frontend\Api\Document;

use App\Models\Auth\Team;
use App\Models\Tour\Tour;
use App\Models\Tour\TourOrder;
use Carbon\Carbon;

/**
 *  Class DocumentRepository
 * 
 *  @package App\Repositories
 */
class LabelsRepository
{

  /**
   * Получить массив меток и их значений для подстановки в шаблоны
   * документов.
   * 
   * @param int|null $perPage
   * 
   * @return array
   */
  public function getTeamLabelsWithValues($team_id) 
  {
    $agent = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
        
    $agent_profiles = $agent->getProfilesAttribute();

    $operator = Team::where('id', $team_id)->first();

    $operator_profiles = $operator->getProfilesAttribute();
    
    $labels = [
      // Operator info
      'полное название компании'
        => $operator->name,
      'полное название компании'
        => $operator_profiles['formal']['company_full_name'],
      'ФИО генерального директора'
        => $operator_profiles['formal']['company_ceo_name'],
      'ФИО генерального директора в родительном падеже'
        => $operator_profiles['formal']['company_ceo_name_genetive'],
      'инн компании'
        => $operator_profiles['formal']['company_inn'],
      'кпп компании'
        => $operator_profiles['formal']['company_kpp'],
      'адрес юридический компании'
        => $operator_profiles['formal']['company_address'],
      'адрес фактический компании'
        => $operator_profiles['formal']['company_real_address'],
      'телефоны компании'
        => $operator_profiles['formal']['company_phone'],
      'рассчетный счет компании'
        => $operator_profiles['formal']['company_bankaccount'],
      'банк компании'
        => $operator_profiles['formal']['company_bankname'],
      'корреспондентский счет компании'
        => $operator_profiles['formal']['company_bankcorr'],
      'бик компании'
        => $operator_profiles['formal']['company_bik'],
      'окпо покупателя'
        => $operator_profiles['formal']['company_okpo'],
      'огрн компании'
        => $operator_profiles['formal']['company_ogrn'],
      'оквэд компании'
        => $operator_profiles['formal']['company_okved'],

      // Agent info

      'компания покупателя'
        => $agent->name,
      'полное название компании'
        => $agent_profiles['formal']['company_full_name'],
      'ФИО генерального директора'
        => $agent_profiles['formal']['company_ceo_name'],
      'ФИО генерального директора в родительном падеже'
        => $agent_profiles['formal']['company_ceo_name_genetive'],
      'инн покупателя'
        => $agent_profiles['formal']['company_inn'],
      'кпп покупателя'
        => $agent_profiles['formal']['company_kpp'],
      'адрес юридический покупателя'
        => $agent_profiles['formal']['company_address'],
      'адрес фактический покупателя'
        => $agent_profiles['formal']['company_real_address'],
      'телефоны покупателя'
        => $agent_profiles['formal']['company_phone'],
      'рассчетный счет покупателя'
        => $agent_profiles['formal']['company_bankaccount'],
      'банк покупателя'
        => $agent_profiles['formal']['company_bankname'],
      'корреспондентский счет покупателя'
        => $agent_profiles['formal']['company_bankcorr'],
      'бик покупателя'
        => $agent_profiles['formal']['company_bik'],
      'окпо покупателя'
        => $agent_profiles['formal']['company_okpo'],
      'огрн покупателя'
        => $agent_profiles['formal']['company_ogrn'],
      'оквэд покупателя'
        => $agent_profiles['formal']['company_okved'],
    ];
    
    return compact('labels');
  }

  public function getTouristLabelsWithValues($order_id, $tour_id) {

    $order = TourOrder::where('id', $order_id)->first();
    $profiles = $order->profiles()->get()->pluck('content')->first();
    $all_tourists_info = '';
    $count_adl = 0;
    $count_chld = 0;
    foreach($profiles as $profile)
    {
      $all_tourists_info = $all_tourists_info
        .$profile['first_name']." "
        .$profile['last_name'].", "
        ."документ: "
        .$profile['passport'].", "
        ."дата рождения: "
        .$profile['dob'].". ";
      $today = Carbon::now();
      $profile_dob =  new Carbon($profile['dob']);
      $result = $today->diffInYears($profile_dob);
      if ($result > 18) 
      {
        $count_adl++;
      }
      else 
      {
        $count_chld++;
      }
    }

    $tour = Tour::whereId($tour_id)->AllTeams()->first();
    $tour_options = json_decode($tour->extra);
    // dd($tour_options);

    $hotels_info = '';
    if ($tour_options->hotel)
    {
      foreach($tour_options->hotel as $hotel) 
      {
        $hotels_info = 
          $hotels_info
          .$hotel->hotel->name.": "
          .$hotel->obj->name.". <br>";
      }
    }

    $excursions_info = '';
    if ($tour_options->museum)
    {
      foreach($tour_options->museum as $museum)
      {
        $excursions_info = 
          $excursions_info
          .$museum->museum->name.": "
          .$museum->obj->name.". <br>";
      }
    }

    $transport_info = '';
    if ($tour_options->transport)
    {
      foreach($tour_options->transport as $transport)
      {
        $transport_info = 
          $transport_info
          .$transport->transport->name.": "
          .$transport->obj->name.". <br>";
      }
    }

    $additional_services_info = '';
    if ($tour_options->customPrice)
    {
      foreach($tour_options->customPrice as $additional_service)
      {
        $additional_services_info = 
          $additional_services_info
          .$additional_service->name.". <br>";
      }
    }

    $agent = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
    $agent_profiles = $agent->getProfilesAttribute();
    $labels = [
      // Order info 
      'внутренний номер заявки'
        => $order->id,
      'дата печати'
        => (new Carbon($order->updated_at))->isoFormat('d MMM Y'),
      'стоимость тура'
        => $order->total_price,
      'информация по туристам, без полученных документов'
        => $all_tourists_info,
      'количество туристов, взрослые'
        => $count_adl,
      'количество туристов, дети'
        => $count_chld,
      // 'информация по пакетному туру'
      //   => 'информация по пакетному туру не заполнена',
      'информация по отелям'
        => $hotels_info,
      'информация по экскурсиям'
        => $excursions_info,
      'информация по трансферам'
        => $transport_info,
      'информация по доп.услугам'
        => $additional_services_info,

      // Agent info
      'город компании'
        => $agent_profiles['formal']['company_city'],
      'название компании'
        => $agent->name,
      'полное название компании'
        => $agent_profiles['formal']['company_full_name'],
      'ФИО генерального директора'
        => $agent_profiles['formal']['company_ceo_name'],
      'ФИО генерального директора в родительном падеже'
        => $agent_profiles['formal']['company_ceo_name_genetive'],
      'адрес юридический компании'
        => $agent_profiles['formal']['company_address'],
      'адрес фактический компании'
        => $agent_profiles['formal']['company_real_address'],
      'инн компании'
        => $agent_profiles['formal']['company_inn'],
      'кпп компании'
        => $agent_profiles['formal']['company_kpp'],
      'телефоны компании'
        => $agent_profiles['formal']['company_phone'],
      'e-mail компании'
        => $agent_profiles['formal']['company_email'],
      'рассчетный счет компании'
        => $agent_profiles['formal']['company_bankaccount'],
      'банк компании'
        => $agent_profiles['formal']['company_bankname'],
      'корреспондентский счет компании'
        => $agent_profiles['formal']['company_bankcorr'],
      'бик компании'
        => $agent_profiles['formal']['company_bik'],
      'окпо компании'
        => $agent_profiles['formal']['company_okpo'],
      'огрн компании'
        => $agent_profiles['formal']['company_ogrn'],
      'оквэд компании'
        => $agent_profiles['formal']['company_okved'],
      'офис менеджера, адрес и телефон'
        => $agent_profiles['formal']['company_manager'],


      // Tourist info
      'ФИО покупателя'
        => $profiles[0]['first_name']." ".$profiles[0]['last_name'],
      'паспортные данные покупателя'
        => $profiles[0]['passport'],
      'адрес покупателя'
        => $profiles[0]['address'],
      'телефон покупателя'
        => $profiles[0]['phone'],
      'e-mail покупателя'
          => $profiles[0]['email'],
    ];
    // dd($labels);
    return compact('order', 'profiles', 'tour', 'agent', 'agent_profiles', 'labels');
  }

  public function labelsList() {
    $labels = [
      'компания покупателя',
      'инн покупателя',
      'кпп покупателя',
      'адрес юридический покупателя',
      'адрес фактический покупателя',
      'адрес покупателя',
      'телефон покупателя',
      'рассчетный счет покупателя',
      'банк покупателя',
      'корреспондентский счет покупателя',
      'бик покупателя',
      'огрн покупателя',
      'оквэд покупателя',
      'полное название компании',
      'инн компании',
      'кпп компании',
      'адрес юридический компании',
      'адрес фактический компании',
      'телефоны компании',
      'рассчетный счет компании',
      'банк компании',
      'корреспондентский счет компании',
      'бик компании',
      'огрн компании',
      'оквэд компании',
      'город компании',
      'внутренний номер заявки',
      'дата печати',
      'полное название компании',
      'ФИО генерального директора в родительном падеже',
      'стоимость тура',
      'внутренний номер заявки',
      'дата печати',
      'офис менеджера, адрес и телефон',
      'ФИО генерального директора',
      // 'печать и подпись генерального директора',
      'ФИО покупателя',
      'паспортные данные покупателя',
      'адрес покупателя',
      'телефон покупателя',
      'e-mail покупателя',
      'информация по туристам, без полученных документов',
      'количество туристов, взрослые',
      'количество туристов, дети',
      // 'информация по пакетному туру',
      'информация по отелям',
      'информация по экскурсиям',
      'информация по трансферам',
      // 'информация по страховке',
      // 'информация по визам',
      'информация по доп.услугам',
      // 'стоимость тура в валюте',
      // 'сумма оплаты клиента в заявке, предоплата',
      // 'сумма оплаты клиента в заявке, доплата',
      // 'финансовые гарантии туроператора',

    ];

    return $labels;
  }

}