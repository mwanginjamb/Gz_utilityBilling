<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit".
 *
 * @property int $id
 * @property string|null $unit_name
 * @property int|null $tenant_id
 * @property int|null $property_id
 * @property int|null $created_at
 * @property int|null $update_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $deleted
 * @property int|null $deleted_at
 * @property int|null $deleted_by
 *
 * @property Property $property
 * @property Tenant $tenant
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'property_id', 'created_at', 'update_at', 'created_by', 'updated_by', 'deleted', 'deleted_at', 'deleted_by'], 'integer'],
            [['unit_name'], 'string', 'max' => 50],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['property_id' => 'id']],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tenant::class, 'targetAttribute' => ['tenant_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'unit_name' => Yii::t('app', 'Unit Name'),
            'tenant_id' => Yii::t('app', 'Tenant ID'),
            'property_id' => Yii::t('app', 'Property ID'),
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
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery|PropertyQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Property::class, ['id' => 'property_id']);
    }

    /**
     * Gets query for [[Tenant]].
     *
     * @return \yii\db\ActiveQuery|TenantQuery
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::class, ['id' => 'tenant_id']);
    }

    /**
     * {@inheritdoc}
     * @return UnitQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UnitQuery(get_called_class());
    }
}
