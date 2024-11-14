<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property int $id
 * @property int|null $estate_id
 * @property string|null $billing_date
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['estate_id', 'created_at', 'updated_at'], 'integer'],
            [['billing_date'], 'date', 'format' => 'php:Y-m-d'],
            ['estate_id', 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'estate_id' => Yii::t('app', 'Estate ID'),
            'billing_date' => Yii::t('app', 'Billing Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ScheduleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScheduleQuery(get_called_class());
    }
}
