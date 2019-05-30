<?php


namespace App\Events\Frontend\Order;

use App\Models\Tour\TourOrder;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrderCreated
 * @package App\Events\Frontend\Order
 */
class OrderCreated
{
    use SerializesModels;

    /**
     * @var TourOrder
     */
    public $order;

    /**
     * OrderCreated constructor.
     * @param TourOrder $order
     */
    public function __construct(TourOrder $order)
    {
        $this->order = $order;
    }

}