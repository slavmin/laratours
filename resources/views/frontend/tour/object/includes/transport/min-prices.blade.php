<?php 
    $prices_array = $object_attribute->priceable;
    if (count($prices_array) > 0) {
        $km_prices = [];
        $hour_prices = [];
        foreach($prices_array as $price) {
            if ($price->tour_price_type_id == 1) {
                array_push($hour_prices, $price);
            }
            if ($price->tour_price_type_id == 4) {
                array_push($km_prices, $price);
            }
        }
        $min_km_price = 0;
        if(count($km_prices) > 0) {
            $min_km_price = $km_prices[0]->price;
            foreach($km_prices as $price) {
                if ($min_km_price > $price->price) {
                    $min_km_price = $price->price;
                }
            }
        } else {
            $min_km_price = 'Нет цены за км';
        }
        $min_hour_price = 0;
        if(count($hour_prices) > 0) {
            $min_hour_price = $hour_prices[0]->price;
            foreach($hour_prices as $price) {
                if ($min_hour_price > $price->price) {
                    $min_hour_price = $price->price;
                }
            }
        } else {
            $min_hour_price = 'Нет цены за час';
        }
        $result = 'Км: ' 
                . $min_km_price 
                . ' Час: '
                . $min_hour_price;
    } else {
        $result = 'цены не найдены';
    }
?>
{{ $result }}