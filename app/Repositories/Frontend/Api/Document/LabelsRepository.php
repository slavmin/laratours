<?php

namespace App\Repositories\Frontend\Api\Document;

use App\Models\Auth\Team;


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
  public function getLabels($team_id) 
  {
    $agent = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
        
    $agent_profiles = $agent->getProfilesAttribute();

    $operator = Team::where('id', $team_id)->first();

    $operator_profiles = $operator->getProfilesAttribute();
    
    $labels = [
      // Operator info
      'полное название компании'
        => $operator->name,
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
      // 'бик компании'
      //   => $operator_profiles['formal']['company_bik'],
      // 'огрн компании'
      //   => $operator_profiles['formal']['company_ogrn'],
      // 'оквэд компании'
      //   => $operator_profiles['formal']['company_okved'],

      // Agent info

      'компания покупателя'
        => $agent->name,
      'инн покупателя'
        => $agent_profiles['formal']['company_inn'],
      'кпп покупателя'
        => $agent_profiles['formal']['company_kpp'],
      'адрес юридический покупателя'
        => $agent_profiles['formal']['company_address'],
      // 'адрес фактический покупателя'
      //   => $agent_profiles['real']['company_address'],
      'телефоны покупателя'
        => $agent_profiles['formal']['company_phone'],
      'рассчетный счет покупателя'
        => $agent_profiles['formal']['company_bankaccount'],
      'банк покупателя'
        => $agent_profiles['formal']['company_bankname'],
      'корреспондентский счет покупателя'
        => $agent_profiles['formal']['company_bankcorr'],
      // 'бик покупателя'
      //   => $agent_profiles['formal']['company_bik'],
      // 'огрн покупателя'
      //   => $agent_profiles['formal']['company_ogrn'],
      // 'оквэд покупателя'
      //   => $agent_profiles['formal']['company_okved'],
    ];
    
    return compact('labels');
    // $columns = [
    //   'id',
    //   'title',
    //   'slug',
    //   'is_published',
    //   'published_at',
    //   'user_id',
    //   'category_id',
    // ];

    // $result = $this
    //   ->startConditions()
    //   ->select($columns)
    //   ->orderBy('id', 'DESC')
    //   ->with([
    //     'category:id,title',
    //     'user:id,name'
    //   ])
    //   ->paginate($perPage);
      
    // return $result;
  }

}