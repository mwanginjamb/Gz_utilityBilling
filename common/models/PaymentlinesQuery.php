<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Paymentlines]].
 *
 * @see Paymentlines
 */
class PaymentlinesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    // list all items in descending order by id by default
    public function init()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }

    /**
     * {@inheritdoc}
     * @return Paymentlines[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Paymentlines|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
