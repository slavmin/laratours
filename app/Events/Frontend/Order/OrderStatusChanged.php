<?php


namespace App\Events\Frontend\Order;

use App\Models\Tour\TourOrder;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrderStatusChanged
 * @package App\Events\Frontend\Order
 */
class OrderStatusChanged
{
    use SerializesModels;

    /**
     * @var TourOrder
     */
    public $order;

    /**
     * OrderStatusChanged constructor.
     * @param TourOrder $order
     */
    public function __construct(TourOrder $order)
    {
        $this->order = $order;
    }

}
