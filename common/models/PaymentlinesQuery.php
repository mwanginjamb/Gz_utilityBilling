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
