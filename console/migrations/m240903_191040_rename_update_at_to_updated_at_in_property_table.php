<?php

use yii\db\Migration;

/**
 * Class m240903_191040_rename_update_at_to_updated_at_in_property_table
 */
class m240903_191040_rename_update_at_to_updated_at_in_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn("property", "update_at", "updated_at");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('property', 'updated_at', 'update_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240903_191040_rename_update_at_to_updated_at_in_property_table cannot be reverted.\n";

        return false;
    }
    */
}
