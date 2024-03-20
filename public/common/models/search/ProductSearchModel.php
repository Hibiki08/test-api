<?php

namespace common\models\search;

use yii\base\Model;

/**
 * Class ProductSearchModel
 * @package common\models\search
 */
class ProductSearchModel extends Model
{
    public string $name;
    public string $slug;

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
            [['name', 'slug'], 'string'],
            [['name', 'slug'], 'trim'],
        ];
    }
}