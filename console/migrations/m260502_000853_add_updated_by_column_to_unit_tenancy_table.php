<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%unit_tenancy}}`.
 */
class m260502_000853_add_updated_by_column_to_unit_tenancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%unit_tenancy}}', 'updated_by', $this->integer(25));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%unit_tenancy}}', 'updated_by');
    }
}
