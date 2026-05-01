<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%property}}`.
 */
class m241112_120121_add_billing_type_column_to_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%property}}', 'billing_type', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%property}}', 'billing_type');
    }
}
