<?php


namespace App\Http\Controllers\Api\Tour;

use App\Exceptions\GeneralException;
use App\Models\Tour\TourType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;


class TourOptionsController extends Controller
{
    public function getOptions(Request $request)
    {
        //$model_alias = Tour::getModelAliasAttribute();

        $countries_cities_options = Tour::getCountriesWithCities();

        $tour_type_options = TourType::getTourTypesAttribute(__('validation.attributes.frontend.general.select'));

        $hotel_options = Tour::getHotelsOption();

        $museum_options = Tour::getMuseumsOption();

        $transport_options = Tour::getTransportsOption();

        $meal_options = Tour::getMealsOption();

        $guide_options = Tour::getGuidesOption();

        $attendant_options = Tour::getAttendantsOption();

        return response()->json([
            compact('countries_cities_options', 'tour_type_options', 'hotel_options', 'museum_options', 'meal_options', 'transport_options', 'attendant_options', 'guide_options')
        ]);
    }

}