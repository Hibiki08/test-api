<?php

namespace common\helpers;

use Yii;

/**
 * Class TokenHelper
 * @package common\helpers
 */
class TokenHelper
{
    /**
     * @param string $token
     * @return string
     */
    public static function getSalt(string $token): string
    {
        return md5($token . Yii::$app->params['user.tokenSalt']);
    }

    /**
     * Returns the token in the format: auth_key-salt
     *
     * @param string $token
     * @return string
     */
    public static function getFullToken(string $token): string
    {
        return $token . '-' . self::getSalt($token);
    }
}