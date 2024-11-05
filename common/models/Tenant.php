<?php

namespace common\models;

use Yii;
use common\models\Property;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tenant".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $principle_tenant_name
 * @property string|null $house_number
 * @property string|null $cell_number
 * @property string|null $billing_email_address
 * @property string|null $id_number
 * @property int|null $agreed_rent_payable
 * @property int|null $agreed_water_rate
 * @property int|null $has_signed_tenancy_agreement
 * @property int|null $created_at
 * @property int|null $update_at
 * @property double|null $service_charge
 */
class Tenant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $property;

    public static function tableName()
    {
        return 'tenant';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['principle_tenant_name', 'billing_email_address', 'house_number', 'cell_number', 'agreed_rent_payable', 'agreed_water_rate'], 'required'],
            [['user_id', 'agreed_rent_payable', 'agreed_water_rate', 'has_signed_tenancy_agreement', 'created_at', 'updated_at'], 'integer'],
            [['principle_tenant_name', 'house_number'], 'string', 'max' => 255],
            [['cell_number'], 'string', 'max' => 25],
            [['billing_email_address', 'id_number'], 'string', 'max' => 50],
            ['billing_email_address', 'email'],
            ['house_number', 'unique'],
            ['property', 'string'],
            ['service_charge', 'double'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'principle_tenant_name' => Yii::t('app', 'Principle Tenant Name'),
            'house_number' => Yii::t('app', 'House Number'),
            'cell_number' => Yii::t('app', 'Cell Number'),
            'billing_email_address' => Yii::t('app', 'Billing Email Address'),
            'id_number' => Yii::t('app', 'Id Number'),
            'agreed_rent_payable' => Yii::t('app', 'Agreed Rent Payable'),
            'agreed_water_rate' => Yii::t('app', 'Agreed Water Rate'),
            'has_signed_tenancy_agreement' => Yii::t('app', 'Has Signed Tenancy Agreement'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Update At'),
        ];
    }


    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['id' => 'house_number']);
    }

    public function getPayments()
    {
        return $this->hasMany(Paymentlines::class, ['tenant_id' => 'id']);
    }


    /**
     * {@inheritdoc}
     * @return TenantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TenantQuery(get_called_class());
    }
}
