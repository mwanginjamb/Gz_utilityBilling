<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[AssociatedPayments]].
 *
 * @see AssociatedPayments
 */
class AssociatedPaymentsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    // filter by created_at in descending order
    public function init()
    {
        parent::init();
        $this->orderBy(['created_at' => SORT_DESC]);
    }

    /**
     * {@inheritdoc}
     * @return AssociatedPayments[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AssociatedPayments|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
