<?php 
    $prices_array = $object_attribute->priceable;
    if (count($prices_array) > 0) {
        $min_price = $prices_array[0]->price; 
        foreach($prices_array as $price) {
            if ($min_price > $price->price) {
                $min_price = $price->price;
            }
        }
        $result = 'от ' . $min_price;
    } else {
        $result = 'цены не найдены';
    }
?>
{{ $result }}