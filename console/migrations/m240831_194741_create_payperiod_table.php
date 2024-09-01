<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payperiod}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%property}}`
 * - `{{%payperiodstatus}}`
 */
class m240831_194741_create_payperiod_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payperiod}}', [
            'id' => $this->primaryKey(),
            'period' => $this->date(),
            'body' => $this->text(),
            'property_id' => $this->integer(),
            'payperiodstatus_id' => $this->integer(),
            'created_at' => $this->integer(25),
            'update_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `property_id`
        $this->createIndex(
            '{{%idx-payperiod-property_id}}',
            '{{%payperiod}}',
            'property_id'
        );

        // add foreign key for table `{{%property}}`
        $this->addForeignKey(
            '{{%fk-payperiod-property_id}}',
            '{{%payperiod}}',
            'property_id',
            '{{%property}}',
            'id',
            'CASCADE'
        );

        // creates index for column `payperiodstatus_id`
        $this->createIndex(
            '{{%idx-payperiod-payperiodstatus_id}}',
            '{{%payperiod}}',
            'payperiodstatus_id'
        );

        // add foreign key for table `{{%payperiodstatus}}`
        $this->addForeignKey(
            '{{%fk-payperiod-payperiodstatus_id}}',
            '{{%payperiod}}',
            'payperiodstatus_id',
            '{{%payperiodstatus}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%property}}`
        $this->dropForeignKey(
            '{{%fk-payperiod-property_id}}',
            '{{%payperiod}}'
        );

        // drops index for column `property_id`
        $this->dropIndex(
            '{{%idx-payperiod-property_id}}',
            '{{%payperiod}}'
        );

        // drops foreign key for table `{{%payperiodstatus}}`
        $this->dropForeignKey(
            '{{%fk-payperiod-payperiodstatus_id}}',
            '{{%payperiod}}'
        );

        // drops index for column `payperiodstatus_id`
        $this->dropIndex(
            '{{%idx-payperiod-payperiodstatus_id}}',
            '{{%payperiod}}'
        );

        $this->dropTable('{{%payperiod}}');
    }
}
