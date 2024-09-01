<?php

namespace common\models;

use Yii;

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
 */
class Tenant extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tenant';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'agreed_rent_payable', 'agreed_water_rate', 'has_signed_tenancy_agreement', 'created_at', 'update_at'], 'integer'],
            [['principle_tenant_name', 'house_number'], 'string', 'max' => 255],
            [['cell_number'], 'string', 'max' => 15],
            [['billing_email_address', 'id_number'], 'string', 'max' => 50],
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
        return $this->hasOne(Unit::class, ['unit_name' => 'house_number']);
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
