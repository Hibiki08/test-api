<?php

namespace backend\controllers;

use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

/**
 * Class OrdersController
 * @package backend\controllers
 */
class OrdersController extends ActiveController
{
    public $modelClass = 'common\models\Order';

    /**
     * @inheritdoc
     */
    public function behaviors(): array
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
                        return \Yii::$app->user->can('viewOrder');
                    },
                ],
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return \Yii::$app->user->can('viewOrder');
                    },
                ],
                [
                    'allow' => true,
                    'actions' => ['update'],
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return \Yii::$app->user->can('updateOrder');
                    },
                ],
            ],
        ];

        return $behaviors;
    }
}