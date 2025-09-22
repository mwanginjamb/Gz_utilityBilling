<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%associated_payments}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%paymentlines}}`
 */
class m250922_102315_create_associated_payments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%associated_payments}}', [
            'id' => $this->primaryKey(),
            'paymentline_id' => $this->integer(),
            'payment_description' => $this->string(250),
            'payment_amount' => $this->decimal(),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `paymentline_id`
        $this->createIndex(
            '{{%idx-associated_payments-paymentline_id}}',
            '{{%associated_payments}}',
            'paymentline_id'
        );

        // add foreign key for table `{{%paymentlines}}`
        $this->addForeignKey(
            '{{%fk-associated_payments-paymentline_id}}',
            '{{%associated_payments}}',
            'paymentline_id',
            '{{%paymentlines}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%paymentlines}}`
        $this->dropForeignKey(
            '{{%fk-associated_payments-paymentline_id}}',
            '{{%associated_payments}}'
        );

        // drops index for column `paymentline_id`
        $this->dropIndex(
            '{{%idx-associated_payments-paymentline_id}}',
            '{{%associated_payments}}'
        );

        $this->dropTable('{{%associated_payments}}');
    }
}
