<?php

use yii\db\Migration;

/**
 * Class m240906_205430_alter_cell_number_column_on_tenant_table
 */
class m240906_205430_alter_cell_number_column_on_tenant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn("tenant", "cell_number", "string(25)");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn("tenant", "cell_number", "string(15)");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240906_205430_alter_cell_number_column_on_tenant_table cannot be reverted.\n";

        return false;
    }
    */
}
