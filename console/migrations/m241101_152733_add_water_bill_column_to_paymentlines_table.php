<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%paymentlines}}`.
 */
class m241101_152733_add_water_bill_column_to_paymentlines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%paymentlines}}', 'water_bill', $this->double());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%paymentlines}}', 'water_bill');
    }
}
