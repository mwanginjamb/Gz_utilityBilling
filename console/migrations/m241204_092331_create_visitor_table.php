<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%visitor}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%relationship}}`
 */
class m241204_092331_create_visitor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%visitor}}', [
            'id' => $this->primaryKey(),
            'tenant_id' => $this->integer(),
            'fullnames' => $this->string(150),
            'cell_number' => $this->string(50),
            'email_address' => $this->string(50),
            'vehicle_reg_no' => $this->string(15),
            'relationship' => $this->integer(),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `relationship`
        $this->createIndex(
            '{{%idx-visitor-relationship}}',
            '{{%visitor}}',
            'relationship'
        );

        // create index for column `cell_number`,`fullnames`,`email_address` and `vehicle_reg_no`

        $this->createIndex(
            '{{%idx-visitor-bio}}',
            '{{%visitor}}',
            ['fullnames', 'cell_number', 'email_address', 'vehicle_reg_no']
        );

        // add foreign key for table `{{%relationship}}`
        $this->addForeignKey(
            '{{%fk-visitor-relationship}}',
            '{{%visitor}}',
            'relationship',
            '{{%relationship}}',
            'id',
            'CASCADE'
        );

        // creates index for column `tenant_id`
        $this->createIndex(
            '{{%idx-visitor-tenant_id}}',
            '{{%visitor}}',
            'tenant_id'
        );

        // add foreign key for table `{{%tenant}}`
        $this->addForeignKey(
            '{{%fk-visitor-tenant_id}}',
            '{{%visitor}}',
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
        // drops foreign key for table `{{%relationship}}`
        $this->dropForeignKey(
            '{{%fk-visitor-relationship}}',
            '{{%visitor}}'
        );

        // drops index for column `relationship`
        $this->dropIndex(
            '{{%idx-visitor-relationship}}',
            '{{%visitor}}'
        );

        $this->dropTable('{{%visitor}}');
    }
}
