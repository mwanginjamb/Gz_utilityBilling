<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paymentheader".
 *
 * @property int $id
 * @property int|null $payperiod_id
 * @property int|null $property_id
 * @property int|null $created_at
 * @property int|null $update_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Paymentlines[] $paymentlines
 * @property Payperiod $payperiod
 * @property Property $property
 */
class Paymentheader extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paymentheader';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payperiod_id', 'property_id', 'created_at', 'update_at', 'created_by', 'updated_by'], 'integer'],
            [['payperiod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payperiod::class, 'targetAttribute' => ['payperiod_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'payperiod_id' => Yii::t('app', 'Payperiod ID'),
            'property_id' => Yii::t('app', 'Property ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Update At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Paymentlines]].
     *
     * @return \yii\db\ActiveQuery|PaymentlinesQuery
     */
    public function getPaymentlines()
    {
        return $this->hasMany(Paymentlines::class, ['paymentheader_id' => 'id']);
    }

    /**
     * Gets query for [[Payperiod]].
     *
     * @return \yii\db\ActiveQuery|PayperiodQuery
     */
    public function getPayperiod()
    {
        return $this->hasOne(Payperiod::class, ['id' => 'payperiod_id']);
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
     * @return PaymentheaderQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentheaderQuery(get_called_class());
    }
}
