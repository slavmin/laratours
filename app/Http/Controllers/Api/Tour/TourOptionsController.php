<?php


namespace App\Http\Controllers\Api\Tour;

use App\Models\Tour\TourHotel;
use App\Models\Tour\TourMuseum;
use App\Models\Tour\TourTransport;
use App\Models\Tour\TourType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour\Tour;


class TourOptionsController extends Controller
{
    public function getOptions(Request $request)
    {

        $countries_cities_options = Tour::getCountriesWithCities();

        $tour_type_options = TourType::getTourTypesAttribute(__('validation.attributes.frontend.general.select'));
        reset( $tour_type_options );
        unset( $tour_type_options[ key($tour_type_options)]);

        $hotel_options = TourHotel::with('objectables')->get();

        $museum_options = TourMuseum::with('objectables')->get();

        $transport_options = TourTransport::with('objectables')->get();

        $hotel_options = $hotel_options->map(function ($hotel) {
            return [
                'id' => $hotel->id,
                'city_id' => $hotel->city_id,
                'name' => $hotel->name,
                'description' => $hotel->description,
                'qnt' => $hotel->qnt,
                'objectables' => $hotel->objectables->map(function ($objectable) {
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

        $museum_options = $museum_options->map(function ($museum) {
            return [
                'id' => $museum->id,
                'city_id' => $museum->city_id,
                'name' => $museum->name,
                'description' => $museum->description,
                'qnt' => $museum->qnt,
                'objectables' => $museum->objectables->map(function ($objectable) {
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

        $transport_options = $transport_options->map(function ($transport) {
            return [
                'id' => $transport->id,
                'city_id' => $transport->city_id,
                'name' => $transport->name,
                'description' => $transport->description,
                'qnt' => $transport->qnt,
                'objectables' => $transport->objectables->map(function ($objectable) {
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


        $meal_options = Tour::getMealsOption();

        $guide_options = Tour::getGuidesOption();

        $attendant_options = Tour::getAttendantsOption();

        return response()->json([
            compact('countries_cities_options', 'tour_type_options', 'hotel_options', 'museum_options', 'meal_options', 'transport_options', 'attendant_options', 'guide_options')
        ]);
    }

}