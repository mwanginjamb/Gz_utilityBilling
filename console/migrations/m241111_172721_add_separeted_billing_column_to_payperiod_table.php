<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%payperiod}}`.
 */
class m241111_172721_add_separeted_billing_column_to_payperiod_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%payperiod}}', 'separated_billing', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%payperiod}}', 'separated_billing');
    }
}
