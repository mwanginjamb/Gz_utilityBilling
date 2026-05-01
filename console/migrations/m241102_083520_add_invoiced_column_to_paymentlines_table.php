<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%paymentlines}}`.
 */
class m241102_083520_add_invoiced_column_to_paymentlines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%paymentlines}}', 'invoiced', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%paymentlines}}', 'invoiced');
    }
}
