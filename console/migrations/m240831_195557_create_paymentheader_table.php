<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%paymentheader}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%payperiod}}`
 * - `{{%property}}`
 */
class m240831_195557_create_paymentheader_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%paymentheader}}', [
            'id' => $this->primaryKey(),
            'payperiod_id' => $this->integer(),
            'property_id' => $this->integer(),
            'created_at' => $this->integer(25),
            'update_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `payperiod_id`
        $this->createIndex(
            '{{%idx-paymentheader-payperiod_id}}',
            '{{%paymentheader}}',
            'payperiod_id'
        );

        // add foreign key for table `{{%payperiod}}`
        $this->addForeignKey(
            '{{%fk-paymentheader-payperiod_id}}',
            '{{%paymentheader}}',
            'payperiod_id',
            '{{%payperiod}}',
            'id',
            'CASCADE'
        );

        // creates index for column `property_id`
        $this->createIndex(
            '{{%idx-paymentheader-property_id}}',
            '{{%paymentheader}}',
            'property_id'
        );

        // add foreign key for table `{{%property}}`
        $this->addForeignKey(
            '{{%fk-paymentheader-property_id}}',
            '{{%paymentheader}}',
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
        // drops foreign key for table `{{%payperiod}}`
        $this->dropForeignKey(
            '{{%fk-paymentheader-payperiod_id}}',
            '{{%paymentheader}}'
        );

        // drops index for column `payperiod_id`
        $this->dropIndex(
            '{{%idx-paymentheader-payperiod_id}}',
            '{{%paymentheader}}'
        );

        // drops foreign key for table `{{%property}}`
        $this->dropForeignKey(
            '{{%fk-paymentheader-property_id}}',
            '{{%paymentheader}}'
        );

        // drops index for column `property_id`
        $this->dropIndex(
            '{{%idx-paymentheader-property_id}}',
            '{{%paymentheader}}'
        );

        $this->dropTable('{{%paymentheader}}');
    }
}
