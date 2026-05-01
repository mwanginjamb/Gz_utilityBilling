<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $build_date
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Paymentheader[] $paymentheaders
 * @property Payperiod[] $payperiods
 * @property Unit[] $units
 */
class Property extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'property';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['build_date'], 'safe'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'build_date' => 'Build Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Paymentheaders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentheaders()
    {
        return $this->hasMany(Paymentheader::class, ['property_id' => 'id']);
    }

    /**
     * Gets query for [[Payperiods]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPayperiods()
    {
        return $this->hasMany(Payperiod::class, ['property_id' => 'id']);
    }

    /**
     * Gets query for [[Units]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnits()
    {
        return $this->hasMany(Unit::class, ['property_id' => 'id']);
    }
}
