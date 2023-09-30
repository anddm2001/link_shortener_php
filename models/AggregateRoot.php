<?php

namespace app\models;

use Psr\Log\LoggerInterface;
use Yii;
use yii\db\ActiveRecord;

class AggregateRoot extends ActiveRecord
{
    public function init()
    {
        parent::init();

        /** @var LoggerInterface $logger */
        //$logger = Yii::$container->get(LoggerInterface::class);
        //$this->logger = $logger;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        //ToDo Логгирование изменений в модели либо стандартным Yii logger, либо с помощью logger совместимого с Psr.
    }
}