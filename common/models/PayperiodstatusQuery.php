<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Payperiodstatus]].
 *
 * @see Payperiodstatus
 */
class PayperiodstatusQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Payperiodstatus[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Payperiodstatus|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
