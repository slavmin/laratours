<?php

namespace App\Http\Controllers\Api\Document;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\Team;

class LabelsController extends Controller
{
    public function getLabels(Request $request) {
        $team = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
        // dd($team);
        $profiles = $team->getProfilesAttribute();

        $labels = $this->formatLabels($profiles);

        return response()->json([
            compact('team', 'profiles', 'labels')
        ]);
    }

    public static function formatLabels($profiles) {

        $labels = [
            'адрес юридический компании' => $profiles['formal']['company_address'], 
            'инн компании' => $profiles['formal']['company_inn'],
            'кпп компании' => $profiles['formal']['company_kpp'],
            'рассчетный счет компании' => $profiles['formal']['company_bankaccount'],
            'банк компании' => $profiles['formal']['company_bankname'],
            'корреспондентский счет компании' => $profiles['formal']['company_bankcorr'],
        ];
        
        return $labels;
    }
}
