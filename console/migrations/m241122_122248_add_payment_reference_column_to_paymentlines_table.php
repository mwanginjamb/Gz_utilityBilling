<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%paymentlines}}`.
 */
class m241122_122248_add_payment_reference_column_to_paymentlines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%paymentlines}}', 'payment_reference', $this->string(15));

        // Index for payment reference
        $this->createIndex(
            'idx_payment_reference',
            '{{%paymentlines}}',
            'payment_reference'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx_payment_reference', '{{%paymentlines}}');
        $this->dropColumn('{{%paymentlines}}', 'payment_reference');
    }
}
