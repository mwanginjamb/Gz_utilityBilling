<?php

use yii\db\Migration;

/**
 * Class m240901_095102_rename_update_at_to_updated_at_in_tenant_table
 */
class m240901_095102_rename_update_at_to_updated_at_in_tenant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('tenant', 'update_at', 'updated_at');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('tenant', 'updated_at', 'update_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240901_095102_rename_update_at_to_updated_at_in_tenant_table cannot be reverted.\n";

        return false;
    }
    */
}
