<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Paymentheader]].
 *
 * @see Paymentheader
 */
class PaymentheaderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Paymentheader[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Paymentheader|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
