<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "paymentlines".
 *
 * @property int $id
 * @property int|null $paymentheader_id
 * @property int|null $opening_water_readings
 * @property int|null $closing_water_readings
 * @property int|null $settled
 * @property int|null $created_at
 * @property int|null $update_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property Paymentheader $paymentheader
 */
class Paymentlines extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paymentlines';
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
            [['tenant_id', 'tenant_name', 'agreed_rent_payable', 'agreed_water_rate'], 'safe'],
            [['paymentheader_id', 'opening_water_readings', 'closing_water_readings', 'settled', 'created_at', 'update_at', 'created_by', 'updated_by', 'deleted', 'deleted_at', 'deleted_by'], 'integer'],
            [['paymentheader_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymentheader::class, 'targetAttribute' => ['paymentheader_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'paymentheader_id' => Yii::t('app', 'Paymentheader ID'),
            'opening_water_readings' => Yii::t('app', 'Opening Water Readings'),
            'closing_water_readings' => Yii::t('app', 'Closing Water Readings'),
            'settled' => Yii::t('app', 'Settled'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Update At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'deleted' => Yii::t('app', 'Deleted'),
            'deleted_at' => Yii::t('app', 'Deleted At'),
            'deleted_by' => Yii::t('app', 'Deleted By'),
        ];
    }

    /**
     * Gets query for [[Paymentheader]].
     *
     * @return \yii\db\ActiveQuery|PaymentheaderQuery
     */
    public function getPaymentheader()
    {
        return $this->hasOne(Paymentheader::class, ['id' => 'paymentheader_id']);
    }

    public function getTenant()
    {
        return $this->hasOne(Tenant::class, ['id' => 'tenant_id']);
    }

    /**
     * {@inheritdoc}
     * @return PaymentlinesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PaymentlinesQuery(get_called_class());
    }


}
