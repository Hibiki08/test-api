<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Class ProductsController
 * @package backend\controllers
 */
class ProductsController extends ActiveController
{
    public $modelClass = 'common\models\Product';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['index'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->can('viewProduct');
                    },
                ],
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->can('viewProduct');
                    },
                ],
                [
                    'allow' => true,
                    'actions' => ['create'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->can('createProduct');
                    },
                ],
                [
                    'allow' => true,
                    'actions' => ['update'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->can('updateProduct');
                    },
                ],
                [
                    'allow' => true,
                    'actions' => ['delete'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Yii::$app->user->can('deleteProduct');
                    },
                ]
            ],
        ];

        return $behaviors;
    }
}