<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "User".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $referal_url
 * @property string $created_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;


    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],

                ],
                'value' => function(){
                    return gmdate("Y-m-d H:i:s");
                },
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
     public static function findIdentity($id)
     {
         return static::findOne($id);
     }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

     public static function findIdentityByAccessToken($token, $type = null)
     {
         return static::findOne(['access_token' => $token]);
     }

     public function getId()
     {
         return $this->id;
     }

     public function getAuthKey()
     {
         return $this->authKey;
     }

     public function validateAuthKey($authKey)
     {
         return $this->authKey === $authKey;
     }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
