<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

/**
 * Class Order
 * @package common\models
 *
 * @property int $id
 * @property int $product_id
 * @property int $member_id
 * @property int $quantity
 * @property float $price
 * @property string $created_at
 * @property int $status_id
 *
 * @property-read Product $product
 */
class Order extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_PAID = 1;
    const STATUS_CANCELLED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['product_id', 'quantity', 'price'], 'required'],
            [['product_id', 'member_id', 'quantity', 'status_id'], 'integer'],
            ['product_id', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            ['member_id', 'exist', 'targetClass' => Member::class, 'targetAttribute' => 'id'],
            ['quantity', 'integer', 'min' => 1],
            ['status_id', 'in', 'range' => array_keys(self::statusMap())],
            [['price'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'member_id' => 'Member ID',
            'quantity' => 'Quantity',
            'price' => 'Price',
            'created_at' => 'Created At',
            'status_id' => 'Status ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return string[]
     */
    public static function statusMap(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_PAID => 'Paid',
            self::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    /**
     * @param int $productId
     * @param int $quantity
     * @param float $price - price per unit
     * @param int|null $memberId
     * @param int $statusId
     * @return Order
     */
    public static function create(
        int $productId,
        int $quantity,
        float $price,
        int $memberId = null,
        int $statusId = self::STATUS_PENDING
    ): Order {
        $order = new self();
        $order->product_id = $productId;
        $order->member_id = $memberId;
        $order->quantity = $quantity;
        $order->price = $quantity * $price;
        $order->status_id = $statusId;

        return $order;
    }
}