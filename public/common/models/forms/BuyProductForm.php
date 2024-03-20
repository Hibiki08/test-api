<?php

namespace common\models\forms;

use yii\base\Model;

/**
 * Class BuyProductForm
 * @package common\models\forms
 */
class BuyProductForm extends Model
{
    /**
     * @var int|null
     */
    public $quantity = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['quantity'], 'required'],
            [['quantity'], 'integer', 'min' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'quantity' => 'Quantity',
        ];
    }
}