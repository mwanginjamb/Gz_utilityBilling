<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "asset_affiliation".
 *
 * @property int $id
 * @property int|null $tenant_id
 * @property string|null $asset_description
 * @property string|null $asset_unique_identifier
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Tenant $tenant
 */
class AssetAffiliation extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            BlameableBehavior::class
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asset_affiliation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tenant_id', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['asset_description'], 'string'],
            [['asset_unique_identifier'], 'string', 'max' => 150],
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
            'asset_description' => Yii::t('app', 'Asset Description'),
            'asset_unique_identifier' => Yii::t('app', 'Asset Unique Identifier'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
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
     * @return AssetAffiliationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AssetAffiliationQuery(get_called_class());
    }
}
