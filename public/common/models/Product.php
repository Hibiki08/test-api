<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class Product
 * @package common\models
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property float $price
 */
class Product extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%product}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'slug', 'price'], 'required'],
            [['price'], 'number'],
            ['name', 'string', 'max' => 100],
            ['slug', 'string', 'max' => 255],
            [['slug'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'price' => 'Price',
        ];
    }
}