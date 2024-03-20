<?php

namespace frontend\modules\v1\controllers;

use common\models\forms\BuyProductForm;
use common\models\Order;
use common\models\Product;
use common\models\search\ProductSearchModel;
use frontend\modules\v1\renderers\OrderRenderer;
use Yii;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\DataFilter;
use yii\db\ActiveQueryInterface;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\mutex\Mutex;
use yii\rest\IndexAction;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class ProductsController
 * @package frontend\modules\v1\controllers
 */
class ProductsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => [
                'optional' => [
                    'view',
                    'buy'
                ]
            ],
        ]);
    }

    /**
     * @return ActiveDataProvider|DataFilter|null
     */
    public function actionView(): ActiveDataProvider|DataFilter|null
    {
        $action = new IndexAction($this->action->id, $this, [
            'modelClass' => Product::class,
            'dataFilter' => [
                'class' => ActiveDataFilter::class,
                'searchModel' => ProductSearchModel::class,
            ],
            'prepareSearchQuery' => function (ActiveQueryInterface $query) {
                return $query->cache(60 * 60 * 2);
            }
        ]);

        return $action->run();
    }

    /**
     * @param string $slug
     * @return array
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws UnprocessableEntityHttpException
     * @throws Exception
     */
    public function actionBuy(string $slug): array
    {
        /** @var Mutex $mutex */
        $mutex = Yii::$app->mutex;

        $product = Product::findOne(['slug' => $slug]);

        if (!$product) {
            throw new NotFoundHttpException('Product not found.');
        }

        $form = new BuyProductForm();
        $form->load(Yii::$app->getRequest()->post(), '');

        if (!$form->validate()) {
            $this->renderFirstErrorFromModel($form);
        }

        if ($mutex->acquire($slug)) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $member = $this->getMember();
                $memberId = $member?->id;
                $order = Order::create($product->id, $form->quantity, $product->price, $memberId);

                // payment logic

                if (true) // if paid
                {
                    $order->status_id = Order::STATUS_PAID;
                } else {
                    $order->status_id = Order::STATUS_CANCELLED;
                }

                if ($order->save()) {
                    $transaction->commit();
                    return (new OrderRenderer($order))->generateResponse();
                } else {
                    $this->renderFirstErrorFromModel($order);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } finally {
                $mutex->release($slug);
            }
        } else {
            throw new HttpException(423, 'Resource is temporarily unavailable');
        }
    }
}