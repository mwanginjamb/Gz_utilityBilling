<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%paymentlines}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%paymentheader}}`
 */
class m240831_200526_create_paymentlines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%paymentlines}}', [
            'id' => $this->primaryKey(),
            'paymentheader_id' => $this->integer(),
            'opening_water_readings' => $this->integer(),
            'closing_water_readings' => $this->integer(),
            'settled' => $this->boolean(),
            'created_at' => $this->integer(25),
            'update_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
            'deleted' => $this->boolean(),
            'deleted_at' => $this->integer(25),
            'deleted_by' => $this->integer(),
        ]);

        // creates index for column `paymentheader_id`
        $this->createIndex(
            '{{%idx-paymentlines-paymentheader_id}}',
            '{{%paymentlines}}',
            'paymentheader_id'
        );

        // add foreign key for table `{{%paymentheader}}`
        $this->addForeignKey(
            '{{%fk-paymentlines-paymentheader_id}}',
            '{{%paymentlines}}',
            'paymentheader_id',
            '{{%paymentheader}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%paymentheader}}`
        $this->dropForeignKey(
            '{{%fk-paymentlines-paymentheader_id}}',
            '{{%paymentlines}}'
        );

        // drops index for column `paymentheader_id`
        $this->dropIndex(
            '{{%idx-paymentlines-paymentheader_id}}',
            '{{%paymentlines}}'
        );

        $this->dropTable('{{%paymentlines}}');
    }
}
