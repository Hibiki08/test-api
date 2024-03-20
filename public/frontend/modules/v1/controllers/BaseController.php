<?php

namespace frontend\modules\v1\controllers;

use common\models\Member;
use Yii;
use yii\base\Model;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class BaseController
 * @package frontend\modules\v1\controllers
 */
class BaseController extends Controller
{
    private ?Member $_member = null;

    /** {@inheritdoc} */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => \yii\filters\auth\HttpBearerAuth::class,
        ];

        return $behaviors;
    }

    /**
     * @return Member|null
     */
    public function getMember(): ?Member
    {
        return $this->_member;
    }

    /**
     * @param Member|null $member
     * @return void
     */
    public function setMember(Member $member = null): void
    {
        $this->_member = $member;
    }

    /**
     * @param $action
     * @return bool
     * @throws BadRequestHttpException
     */
    public function beforeAction($action): bool
    {
        if (parent::beforeAction($action)) {
            $this->_member = Yii::$app->user->identity;
        }

        return true;
    }

    /**
     * @param Model $form
     * @return array
     * @throws UnprocessableEntityHttpException
     */
    public function renderFirstErrorFromModel(Model $form): array
    {
        $errors = $form->getFirstErrors();
        throw new UnprocessableEntityHttpException(array_shift($errors));
    }
}