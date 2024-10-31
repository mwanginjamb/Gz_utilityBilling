<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%paymentlines}}`.
 */
class m241030_224532_add_tenant_id_column_to_paymentlines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%paymentlines}}', 'tenant_id', $this->integer());
        $this->addColumn('{{%paymentlines}}', 'tenant_name', $this->string(150));
        $this->addColumn('{{%paymentlines}}', 'agreed_rent_payable', $this->double());
        $this->addColumn('{{%paymentlines}}', 'agreed_water_rate', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%paymentlines}}', 'tenant_id');
        $this->dropColumn('{{%paymentlines}}', 'tenant_name');
        $this->dropColumn('{{%paymentlines}}', 'agreed_rent_payable');
        $this->dropColumn('{{%paymentlines}}', 'agreed_water_rate');
    }
}
