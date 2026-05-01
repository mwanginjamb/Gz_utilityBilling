<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "visitor".
 *
 * @property int $id
 * @property int|null $tenant_id
 * @property string|null $fullnames
 * @property string|null $cell_number
 * @property string|null $email_address
 * @property string|null $vehicle_reg_no
 * @property int|null $relationship
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Relationship $relationship0
 * @property Tenant $tenant
 */
class Visitor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }
    public static function tableName()
    {
        return 'visitor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'relationship', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['fullnames'], 'string', 'max' => 150],
            [['cell_number', 'email_address'], 'string', 'max' => 50],
            [['vehicle_reg_no'], 'string', 'max' => 15],
            [['relationship'], 'exist', 'skipOnError' => true, 'targetClass' => Relationship::class, 'targetAttribute' => ['relationship' => 'id']],
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
            'tenant_id' => Yii::t('app', 'Tenant ID'),
            'fullnames' => Yii::t('app', 'Fullnames'),
            'cell_number' => Yii::t('app', 'Cell Number'),
            'email_address' => Yii::t('app', 'Email Address'),
            'vehicle_reg_no' => Yii::t('app', 'Vehicle Reg No'),
            'relationship' => Yii::t('app', 'Relationship'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Relationship0]].
     *
     * @return \yii\db\ActiveQuery|RelationshipQuery
     */
    public function getRelationship0()
    {
        return $this->hasOne(Relationship::class, ['id' => 'relationship']);
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
     * @return VisitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VisitorQuery(get_called_class());
    }
}
