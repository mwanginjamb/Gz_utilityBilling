<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%paymentlines}}`.
 */
class m241101_173403_add_units_used_column_to_paymentlines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%paymentlines}}', 'units_used', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%paymentlines}}', 'units_used');
    }
}
