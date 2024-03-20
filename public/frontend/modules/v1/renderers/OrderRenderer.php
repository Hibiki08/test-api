<?php

namespace frontend\modules\v1\renderers;

use common\models\Order;
use yii\base\BaseObject;

/**
 * Class OrderRenderer
 * @package frontend\modules\v1\renderers
 */
class OrderRenderer extends BaseObject implements IRenderer
{
    private Order $order;

    /**
     * OrderRenderer constructor.
     * @param Order $order
     * @param array $config
     */
    public function __construct(Order $order, array $config = [])
    {
        parent::__construct($config);
        $this->order = $order;
    }

    /**
     * Returns the generated response
     *
     * @return array
     */
    public function generateResponse(): array
    {
        $statusName = Order::statusMap()[$this->order['status_id']] ?? 'Unknown';

        return [
            'id' => $this->order->id,
            'product' => $this->order->product?->name,
            'quantity' => $this->order->quantity,
            'price' => $this->order->price,
            'status' => $statusName,
        ];
    }
}