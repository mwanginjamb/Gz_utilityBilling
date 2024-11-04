<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%paymentlines}}`.
 */
class m241101_175341_add_service_charge_column_to_paymentlines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%paymentlines}}', 'service_charge', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%paymentlines}}', 'service_charge');
    }
}
