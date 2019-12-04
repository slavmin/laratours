<?php


namespace App\Http\Controllers\Api\Tour;

use App\Models\Tour\TourAttendant;
use App\Models\Tour\TourGuide;
use App\Models\Tour\TourHotel;
use App\Models\Tour\TourMeal;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourTransport;
use App\Models\Tour\TourType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;
use App\Models\Auth\Team;


class TourOptionsController extends Controller
{
    public function getOptions(Request $request)
    {

        $countries_cities_options = Tour::getCountriesWithCities();

        $tour_type_options = TourType::getTourTypesAttribute(__('validation.attributes.frontend.general.select'));
        reset( $tour_type_options );
        unset( $tour_type_options[ key($tour_type_options)]);

        $hotel_options = TourHotel::with('objectables')->get();
        $hotel_options = $this->formatOptions($hotel_options);

        $museum_options = TourMuseum::with('objectables')->get();
        $museum_options = $this->formatOptions($museum_options);

        $transport_options = TourTransport::with('objectables')->get();
        $transport_options = $this->formatOptions($transport_options);

        $meal_options = TourMeal::with('objectables')->get();
        $meal_options = $this->formatOptions($meal_options);

        $guide_options = TourGuide::all();
        $guide_options = $this->hideFields($guide_options);

        $attendant_options = TourAttendant::all();
        $attendant_options = $this->hideFields($attendant_options);

        $team = Team::whereId(auth()->user()->current_team_id)->with('roles')->first();
        $subscriptions = [];
        $subscribers = [];

        if($team && $team->roles->contains('name', config('access.teams.agent_role'))){
            $subscriptions = $team->subscriptions->pluck('name','id')->toArray();
        } elseif($team && $team->roles->contains('name', config('access.teams.operator_role'))){
            $subscribers = $team->subscribers->pluck('name','id')->toArray();
        }
        
        return response()->json([
            compact('countries_cities_options', 'tour_type_options', 'hotel_options', 'museum_options', 'meal_options', 'transport_options', 'attendant_options', 'guide_options', 'subscribers', 'subscriptions')
        ]);
    }

    public static function hideFields($collection){
        return $collection->makeHidden(['team_id','updated_at','created_at', 'deleted_at', 'model_alias']);
    }


    public static function formatOptions($arr){

        $arr = $arr->map(function ($item) {
            return [
                'id' => $item->id,
                'city_id' => $item->city_id,
                'name' => $item->name,
                'description' => $item->description,
                'extra' => $item->extra,
                'qnt' => $item->qnt,
                'model_alias' => $item->model_alias,
                'objectables' => $item->objectables->map(function ($objectable) {
                    return [
                        'id' => $objectable->id,
                        'name' => $objectable->name,
                        'description' => $objectable->description,
                        'qnt' => $objectable->qnt,
                        'price' => $objectable->price,
                        'extra' => $objectable->extra,
                    ];
                }),
            ];
        });

        return $arr;
    }

}
