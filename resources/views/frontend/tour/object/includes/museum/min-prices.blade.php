<?php 
    $prices_array = $object_attribute->priceable;
    if (count($prices_array) > 0) {
        $min_price = $prices_array[0]->price; 
        foreach($prices_array as $price) {
            if (($min_price > $price->price) && ($price->price != 0)) {
                $min_price = $price->price;
            }
        }
        if ($min_price == 0) {
            $result = 'бесплатно';
        } else {
            $result = 'от ' . $min_price;
        }
    } else {
        $result = 'цены не найдены';
    }
?>
{{ $result }}