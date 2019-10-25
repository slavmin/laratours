<?php


namespace App\Events\Frontend\Order;

use App\Models\Tour\TourOrder;
use Illuminate\Queue\SerializesModels;

/**
 * Class OrderDeleted
 * @package App\Events\Frontend\Order
 */
class OrderDeleted
{
    use SerializesModels;

    /**
     * @var TourOrder
     */
    public $order;

    /**
     * OrderDeleted constructor.
     * @param TourOrder $order
     */
    public function __construct(TourOrder $order)
    {
        $this->order = $order;
    }

}
