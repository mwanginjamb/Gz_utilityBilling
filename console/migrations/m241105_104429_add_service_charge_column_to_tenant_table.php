<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%tenant}}`.
 */
class m241105_104429_add_service_charge_column_to_tenant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tenant}}', 'service_charge', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tenant}}', 'service_charge');
    }
}
