<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Payperiod]].
 *
 * @see Payperiod
 */
class PayperiodQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Payperiod[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Payperiod|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
