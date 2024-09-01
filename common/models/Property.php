<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "property".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $build_date
 * @property int|null $created_at
 * @property int|null $update_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Paymentheader[] $paymentheaders
 * @property Payperiod[] $payperiods
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
            [['created_at', 'update_at', 'created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'build_date' => Yii::t('app', 'Build Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Update At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Paymentheaders]].
     *
     * @return \yii\db\ActiveQuery|PaymentheaderQuery
     */
    public function getPaymentheaders()
    {
        return $this->hasMany(Paymentheader::class, ['property_id' => 'id']);
    }

    /**
     * Gets query for [[Payperiods]].
     *
     * @return \yii\db\ActiveQuery|PayperiodQuery
     */
    public function getPayperiods()
    {
        return $this->hasMany(Payperiod::class, ['property_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PropertyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyQuery(get_called_class());
    }
}
