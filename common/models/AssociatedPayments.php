<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "associated_payments".
 *
 * @property int $id
 * @property int|null $paymentline_id
 * @property string|null $payment_description
 * @property float|null $payment_amount
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Paymentlines $paymentline
 */
class AssociatedPayments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'associated_payments';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\TimestampBehavior::class,
            \yii\behaviors\BlameableBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['paymentline_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['payment_amount'], 'number'],
            [['payment_description'], 'string', 'max' => 250],
            [['paymentline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paymentlines::class, 'targetAttribute' => ['paymentline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'paymentline_id' => Yii::t('app', 'Paymentline ID'),
            'payment_description' => Yii::t('app', 'Payment Description'),
            'payment_amount' => Yii::t('app', 'Payment Amount'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Paymentline]].
     *
     * @return \yii\db\ActiveQuery|PaymentlinesQuery
     */
    public function getPaymentline()
    {
        return $this->hasOne(Paymentlines::class, ['id' => 'paymentline_id']);
    }

    /**
     * {@inheritdoc}
     * @return AssociatedPaymentsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssociatedPaymentsQuery(get_called_class());
    }
}
