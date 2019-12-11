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
  public function getLabels() 
  {
    $team = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
        
    $profiles = $team->getProfilesAttribute();
    
    $labels = [
      'адрес юридический компании' => $profiles['formal']['company_address'], 
      'инн компании' => $profiles['formal']['company_inn'],
      'кпп компании' => $profiles['formal']['company_kpp'],
      'рассчетный счет компании' => $profiles['formal']['company_bankaccount'],
      'банк компании' => $profiles['formal']['company_bankname'],
      'корреспондентский счет компании' => $profiles['formal']['company_bankcorr'],
    ];
    
    return $labels;
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