<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

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
            [['payperiod_id', 'property_id', 'created_at', 'update_at', 'created_by', 'updated_by'], 'integer'],
            [['payperiod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Payperiod::class, 'targetAttribute' => ['payperiod_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
            [
                ['payperiod_id', 'property_id'],
                'unique',
                'targetAttribute' => ['payperiod_id', 'property_id'],
                'message' => 'The combination of Payperiod ID and Property ID is already in use.'
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


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->generateInvoiceLines();
        }
    }

    // Bulk update function for batch processing
    public function updateOpeningReadingsBatch()
    {
        $header = Paymentheader::findOne($this->id);
        $currentLines = Paymentlines::find()->where(['paymentheader_id' => $header->id])->all();
        foreach ($currentLines as $line) {
            $previousLine = Paymentlines::find()
                ->joinWith('paymentheader')
                ->where(['paymentheader.property_id' => $header->property_id])
                ->andWhere(['paymentlines.tenant_id' => $line->tenant_id])
                ->andWhere(['<', 'paymentheader.payperiod_id', $header->payperiod_id])
                ->orderBy(['paymentheader.payperiod_id' => SORT_DESC])
                ->one();

            if ($previousLine) {
                $line->updateAttributes(['opening_water_readings' => $previousLine->closing_water_readings]);
            }
        }

    }

    protected function generateInvoiceLines()
    {
        $property = $this->property;
        $occupiedUnits = Unit::find()->joinWith('tenant')
            ->andWhere(['property_id' => $property->id])
            ->andWhere(['not', ['tenant.id' => NULL]])->all();
        Yii::$app->utility->log(ArrayHelper::map($occupiedUnits, 'id', 'unit_name'), 'property-units' . $property->name);
        $paymentLines = [];
        if ($occupiedUnits) {
            foreach ($occupiedUnits as $unit) {
                $tenant = $unit->tenant;

                if (is_object($tenant)) {
                    $paymentLines[] = [
                        'paymentheader_id' => $this->id,
                        'opening_water_readings' => 0.00,
                        'closing_water_readings' => 0.00,
                        'tenant_id' => $tenant->id,
                        'tenant_name' => $tenant->principle_tenant_name,
                        'agreed_rent_payable' => $tenant->agreed_rent_payable,
                        'agreed_water_rate' => $tenant->agreed_water_rate,
                        'service_charge' => $tenant->service_charge
                    ];
                }


                Yii::$app->utility->log($paymentLines, 'line-' . $property->name . ' - ' . $this->payperiod->body);

            }

            // batch insert if there are any payment lines generated

            if (count($paymentLines)) {
                Yii::$app->db->createCommand()->batchInsert(
                    Paymentlines::tableName(),
                    [
                        'paymentheader_id',
                        'opening_water_readings',
                        'closing_water_readings',
                        'tenant_id',
                        'tenant_name',
                        'agreed_rent_payable',
                        'agreed_water_rate',
                        'service_charge'
                    ],
                    $paymentLines
                )->execute();
            }
            $this->updateOpeningReadingsBatch();
        }
        return null;
    }

}
