<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payperiodstatus}}`.
 */
class m240831_194638_create_payperiodstatus_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payperiodstatus}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'created_at' => $this->integer(25),
            'update_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payperiodstatus}}');
    }
}
