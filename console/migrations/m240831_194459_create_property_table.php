<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%property}}`.
 */
class m240831_194459_create_property_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%property}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
            'build_date' => $this->date(),
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
        $this->dropTable('{{%property}}');
    }
}
