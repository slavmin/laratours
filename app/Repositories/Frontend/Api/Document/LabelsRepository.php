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
      // 'адрес фактический компании'
      //   => $operator_profiles['real']['company_address'],
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

    $tour = Tour::whereId($tour_id)->AllTeams()->first();

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
      'печать и подпись генерального директора',
      'ФИО покупателя',
      'паспортные данные покупателя',
      'адрес покупателя',
      'телефон покупателя',
      'e-mail покупателя',
    ];

    return $labels;
  }

}