<?php

namespace common\models\search;

use common\models\Product;
use yii\base\Model;

/**
 * Class OrderSearchModel
 * @package common\models\search
 */
class OrderSearchModel extends Model
{
    public ?int $product_id = null;
    public ?string $created_at = null;
    public ?string $expand = null;

    /**
     * {@inheritdoc}
     */
    public function formName(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['product_id'], 'integer'],
            ['product_id', 'exist', 'targetClass' => Product::class, 'targetAttribute' => 'id'],
            [['created_at'], 'date', 'format' => 'php:Y-m-d'],
            [['created_at'], 'trim'],
            [
                'expand',
                'string',
                'isEmpty' => function ($value) {
                    return $value === null;
                }
            ],
            ['expand', 'in', 'range' => ['product']],
        ];
    }
}