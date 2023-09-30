<?php

namespace app\models;

use Yii;
use yii\db\BaseActiveRecord;

/**
 * This is the model class for table "{{%short_url}}".
 *
 * @property int $id
 * @property int $short_url_id
 * @property string $user_platform
 * @property string $user_agent
 * @property string $user_refer
 * @property string $user_ip
 * @property string $user_country
 * @property string $user_city
 * @property int $created_at
 * @property int $updated_at
 */
class UserInfo extends AggregateRoot
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_info}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    BaseActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'short_url_id'], 'integer'],
            [['user_platform', 'user_agent', 'user_refer', 'user_ip', 'user_country', 'user_city'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'short_url_id' => Yii::t('app', 'short_url_id'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_platform' => Yii::t('app', 'user_platform'),
            'user_agent' => Yii::t('app', 'user_agent'),
            'user_refer' => Yii::t('app', 'user_refer'),
            'user_ip' => Yii::t('app', 'user_ip'),
            'user_country' => Yii::t('app', 'user_country'),
            'user_city' => Yii::t('app', 'user_city'),
        ];
    }
}