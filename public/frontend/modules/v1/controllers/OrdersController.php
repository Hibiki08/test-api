<?php

namespace frontend\modules\v1\controllers;

use common\models\Order;
use common\models\search\OrderSearchModel;
use Yii;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\DataFilter;
use yii\filters\AccessControl;
use yii\rest\IndexAction;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class OrdersController
 * @package frontend\modules\v1\controllers
 */
class OrdersController extends BaseController
{
    /** {@inheritdoc} */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['view'],
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * @return ActiveDataProvider|DataFilter|null
     * @throws UnprocessableEntityHttpException
     */
    public function actionView(): ActiveDataProvider|DataFilter|null
    {
        $requestParams = Yii::$app->getRequest()->getQueryParams();
        $orderSearchModel = new OrderSearchModel();
        $orderSearchModel->load($requestParams, '');

        if (!$orderSearchModel->validate()) {
            $this->renderFirstErrorFromModel($orderSearchModel);
        }

        $action = new IndexAction($this->action->id, $this, [
            'modelClass' => Order::class,
            'dataFilter' => [
                'class' => ActiveDataFilter::class,
                'searchModel' => OrderSearchModel::class,
            ],
            'prepareSearchQuery' => function ($query, $requestParams) use ($orderSearchModel) {
                $query->andFilterWhere(['member_id' => $this->getMember()->id]);

                if ($orderSearchModel->expand) {
                    match ($orderSearchModel->expand) {
                        'product' => $query->with('product'),
                        default => $query,
                    };
                }
                return $query;
            }
        ]);

        return $action->run();
    }
}