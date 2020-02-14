<?php


namespace App\Repositories\Frontend\Tour;

use App\Models\Tour\TourCustomerType;
use App\Models\Tour\TourObjectAttributes;

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
   * Принимает имя модели и id объекта.
   * 
   * @param $model_alias, @tour_object_id
   */
  public function getTourObjectData($id)
  {
    $item = TourObjectAttributes::find($id);
    $tour_object = $item->objectable_type::find($item->objectable_id);
    $tour_object_name = $tour_object->name;

    $prices = $item->priceable;

    $cancel_route = route('frontend.tour.' . $tour_object->model_alias . '.index');

    $customer_type_options = TourCustomerType::getCustomerTypesAttribute(__('validation.attributes.frontend.general.select'));

    return compact('item', 'prices', 'customer_type_options', 'tour_object_name', 'cancel_route');
  }
}
