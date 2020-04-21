<?php


namespace App\Repositories\Frontend\Tour;

use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourObjectAttributes;
use App\Models\Tour\TourPriceType;

/**
 *  Class ObjectAttributeRepository
 * 
 *  @package App\Repositories
 */
class ObjectAttributeRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return TourObjectAttributes::class;
    }

    /**
     * Возвращает необходимую для редактирования object attribute
     * информацию о нужном объекте тура в зависимости от его типа.
     * (музей, отель, транспорт и т.д.)
     * 
     * @param @tour_object_attribute_id
     */
    public function getTourObjectData($id = 0, $parent_model_alias = '')
    {
        $item = null;
        $tour_object = null;
        $prices = null;

        if ($id != 0) {
            $item = TourObjectAttributes::find($id);
            $tour_object = $item->objectable_type::find($item->objectable_id);
            $prices = $item->priceable;
            $parent_model_alias = $tour_object->model_alias;
        }

        $price_type_options = TourPriceType::select('name', 'id')->get()->toArray();

        $price_types_for_view = TourPriceType::select('name', 'id')->get()->pluck('name', 'id')->toArray();

        $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

        $cancel_route = route('frontend.tour.' . $parent_model_alias . '.index');

        return compact('item', 'parent_model_alias', 'prices', 'customer_type_options', 'tour_object', 'cancel_route', 'price_type_options', 'price_types_for_view');
    }
}
