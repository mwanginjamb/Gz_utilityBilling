<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payperiod".
 *
 * @property int $id
 * @property string|null $period
 * @property string|null $body
 * @property int|null $property_id
 * @property int|null $payperiodstatus_id
 * @property int|null $created_at
 * @property int|null $update_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Paymentheader[] $paymentheaders
 * @property Payperiodstatus $payperiodstatus
 * @property Property $property
 */
class Payperiod extends \yii\db\ActiveRecord
{

    const STATUS_OPEN = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payperiod';
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::class,
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => 'update_at',
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['payperiodstatus_id', 'default', 'value' => self::STATUS_OPEN],
            [['period', 'property_id'], 'required'],
            [['body'], 'string'],
            [['property_id', 'payperiodstatus_id', 'created_at', 'update_at', 'created_by', 'updated_by'], 'integer'],
            [['payperiodstatus_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payperiodstatus::class, 'targetAttribute' => ['payperiodstatus_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
            [
                ['period', 'property_id'],
                'unique',
                'targetAttribute' => ['period', 'property_id'],
                'message' => 'The combination of period and Property ID has already been taken.'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'period' => Yii::t('app', 'Period'),
            'body' => Yii::t('app', 'Body'),
            'property_id' => Yii::t('app', 'Property ID'),
            'payperiodstatus_id' => Yii::t('app', 'Payperiod Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Update At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Paymentheaders]].
     *
     * @return \yii\db\ActiveQuery|PaymentheaderQuery
     */
    public function getPaymentheaders()
    {
        return $this->hasMany(Paymentheader::class, ['payperiod_id' => 'id']);
    }

    /**
     * Gets query for [[Payperiodstatus]].
     *
     * @return \yii\db\ActiveQuery|PayperiodstatusQuery
     */
    public function getPayperiodstatus()
    {
        return $this->hasOne(Payperiodstatus::class, ['id' => 'payperiodstatus_id']);
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery|PropertyQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }

    /**
     * {@inheritdoc}
     * @return PayperiodQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PayperiodQuery(get_called_class());
    }



}
