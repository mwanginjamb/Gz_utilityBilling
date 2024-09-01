<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%unit}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tenant}}`
 * - `{{%property}}`
 */
class m240901_091010_create_unit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit}}', [
            'id' => $this->primaryKey(),
            'unit_name' => $this->string(50),
            'tenant_id' => $this->integer(),
            'property_id' => $this->integer(),
            'created_at' => $this->integer(25),
            'update_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'deleted' => $this->boolean(),
            'deleted_at' => $this->integer(25),
            'deleted_by' => $this->integer(),
        ]);

        // creates index for column `tenant_id`
        $this->createIndex(
            '{{%idx-unit-tenant_id}}',
            '{{%unit}}',
            'tenant_id'
        );

        // add foreign key for table `{{%tenant}}`
        $this->addForeignKey(
            '{{%fk-unit-tenant_id}}',
            '{{%unit}}',
            'tenant_id',
            '{{%tenant}}',
            'id',
            'CASCADE'
        );

        // creates index for column `property_id`
        $this->createIndex(
            '{{%idx-unit-property_id}}',
            '{{%unit}}',
            'property_id'
        );

        // add foreign key for table `{{%property}}`
        $this->addForeignKey(
            '{{%fk-unit-property_id}}',
            '{{%unit}}',
            'property_id',
            '{{%property}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%tenant}}`
        $this->dropForeignKey(
            '{{%fk-unit-tenant_id}}',
            '{{%unit}}'
        );

        // drops index for column `tenant_id`
        $this->dropIndex(
            '{{%idx-unit-tenant_id}}',
            '{{%unit}}'
        );

        // drops foreign key for table `{{%property}}`
        $this->dropForeignKey(
            '{{%fk-unit-property_id}}',
            '{{%unit}}'
        );

        // drops index for column `property_id`
        $this->dropIndex(
            '{{%idx-unit-property_id}}',
            '{{%unit}}'
        );

        $this->dropTable('{{%unit}}');
    }
}
