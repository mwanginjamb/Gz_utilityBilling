<?php

use yii\db\Migration;

/**
 * Class m241101_160907_add_water_billing_indexes
 */
class m241101_160907_add_water_billing_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Composite index for water readings and billing
        $this->createIndex(
            'idx_water_readings',
            '{{%paymentlines}}',
            [
                'opening_water_readings',
                'closing_water_readings',
                'water_bill'
            ]
        );

        // Index for billing rate
        $this->createIndex(
            'idx_water_rate',
            '{{%paymentlines}}',
            'agreed_water_rate'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop indexes in reverse order of creation
        $this->dropIndex('idx_water_rate', '{{%paymentlines}}');
        $this->dropIndex('idx_water_readings', '{{%paymentlines}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241101_160907_add_water_billing_indexes cannot be reverted.\n";

        return false;
    }
    */
}
