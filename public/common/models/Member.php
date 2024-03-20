<?php

namespace common\models;

use common\helpers\TokenHelper;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class Member
 * @package common\models
 *
 * @property int $id
 * @property string $name
 * @property string $auth_key
 */
class Member extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): Member|IdentityInterface|null
    {
        return self::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): Member|IdentityInterface|null
    {
        $token = explode('-', $token);
        if (!isset($token[0]) || !isset($token[1])) {
            return null;
        }

        $authKey = $token[0];
        $saltPart = $token[1];
        if (TokenHelper::getSalt($authKey) !== $saltPart) {
            return null;
        }

        return Member::findOne(['auth_key' => $authKey]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->auth_key === $authKey;
    }
}