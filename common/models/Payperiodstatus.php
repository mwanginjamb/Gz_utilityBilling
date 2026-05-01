<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "payperiodstatus".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $created_at
 * @property int|null $update_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Payperiod[] $payperiods
 */
class Payperiodstatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payperiodstatus';
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
            'name' => Yii::t('app', 'Status Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Update At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * Gets query for [[Payperiods]].
     *
     * @return \yii\db\ActiveQuery|PayperiodQuery
     */
    public function getPayperiods()
    {
        return $this->hasMany(Payperiod::class, ['payperiodstatus_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return PayperiodstatusQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PayperiodstatusQuery(get_called_class());
    }
}
