<?php

namespace app\models;

use Faker\Provider\DateTime;
use Yii;
use yii\data\ActiveDataProvider;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "referal".
 *
 * @property int $id_referal
 * @property int $id_invited
 *
 * @property User $invited
 * @property User $referal
 */
class Referal extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'referal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_referal', 'id_invited'], 'integer'],
            [['id_invited'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_invited' => 'id']],
            [['id_referal'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['id_referal' => 'id']],];
//            ['created_at' => 'datetime']
    }

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
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'id_referal' => 'Id Referal',
            'id_invited' => 'Id Invited',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvited()
    {
        return $this->hasOne(User::className(), ['id' => 'id_invited']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferal()
    {
        return $this->hasOne(User::className(), ['id' => 'id_referal']);
    }

    /**
     * @param int $id ID User Referal
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function getObjectInvited($id, $pageSize = 20)
    {
        $query = Referal::find()
            ->joinWith('invited')
            ->where(['id_referal' => $id]);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize
            ]
        ]);
    }
}
