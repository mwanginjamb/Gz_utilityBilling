<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%unit_tenancy}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%unit}}`
 * - `{{%tenant}}`
 */
class m260501_202348_create_unit_tenancy_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%unit_tenancy}}', [
            'id' => $this->primaryKey(),
            'unit_id' => $this->integer()->notNull(),
            'tenant_id' => $this->integer()->notNull(),
            'move_in_date' => $this->date()->notNull(),
            'move_out_date' => $this->date(),
            'is_active' => $this->boolean(),
            'notes' => $this->text(),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        // creates index for column `unit_id`
        $this->createIndex(
            '{{%idx-unit_tenancy-unit_id}}',
            '{{%unit_tenancy}}',
            'unit_id'
        );

        // add foreign key for table `{{%unit}}`
        $this->addForeignKey(
            '{{%fk-unit_tenancy-unit_id}}',
            '{{%unit_tenancy}}',
            'unit_id',
            '{{%unit}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tenant_id`
        $this->createIndex(
            '{{%idx-unit_tenancy-tenant_id}}',
            '{{%unit_tenancy}}',
            'tenant_id'
        );

        // add foreign key for table `{{%tenant}}`
        $this->addForeignKey(
            '{{%fk-unit_tenancy-tenant_id}}',
            '{{%unit_tenancy}}',
            'tenant_id',
            '{{%tenant}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%unit}}`
        $this->dropForeignKey(
            '{{%fk-unit_tenancy-unit_id}}',
            '{{%unit_tenancy}}'
        );

        // drops index for column `unit_id`
        $this->dropIndex(
            '{{%idx-unit_tenancy-unit_id}}',
            '{{%unit_tenancy}}'
        );

        // drops foreign key for table `{{%tenant}}`
        $this->dropForeignKey(
            '{{%fk-unit_tenancy-tenant_id}}',
            '{{%unit_tenancy}}'
        );

        // drops index for column `tenant_id`
        $this->dropIndex(
            '{{%idx-unit_tenancy-tenant_id}}',
            '{{%unit_tenancy}}'
        );

        $this->dropTable('{{%unit_tenancy}}');
    }
}
