<?php

namespace app\models;

use yii\web\HttpException;
use Yii;
use yii\db\BaseActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "{{%short_url}}".
 *
 * @property int $id
 * @property string $long_url
 * @property int $user_id
 * @property string $short_url
 * @property int $created_at
 * @property int $updated_at
 */
class ShortUrl extends AggregateRoot
{
    public const GUEST = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%short_urls}}';
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
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['short_url'], 'string', 'max' => 5],
            [['long_url'], 'string', 'max' => 256],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'long_url' => Yii::t('app', 'long_url'),
            'short_url' => Yii::t('app', 'short_url'),
        ];
    }

    public static function validateShortCode($code)
    {
        if (!preg_match('|^[0-9a-zA-Z]{5,5}$|', $code)) {
            throw new HttpException(400, Yii::t('burl', 'ENTER_VALID_SHORT_CODE'));
        }

        $url = self::find()->where(['short_url' => $code])->one();

        if ($url === null) {
            throw new NotFoundHttpException(Yii::t('burl', 'SHORT_CODE_NOT_FOUND') . $code);
        }

        return $url;
    }
}