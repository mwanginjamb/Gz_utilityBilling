<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Tenant]].
 *
 * @see Tenant
 */
class TenantQuery extends \yii\db\ActiveQuery
{
    public function init()
    {
        return $this->orderBy(['id' => SORT_DESC]);
    }


    /**
     * {@inheritdoc}
     * @return Tenant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Tenant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
