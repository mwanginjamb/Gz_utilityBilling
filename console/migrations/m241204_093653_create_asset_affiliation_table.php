<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%asset_affiliation}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%tenant}}`
 */
class m241204_093653_create_asset_affiliation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%asset_affiliation}}', [
            'id' => $this->primaryKey(),
            'tenant_id' => $this->integer(),
            'asset_description' => $this->text(),
            'asset_unique_identifier' => $this->string(150),
            'created_at' => $this->integer(25),
            'updated_at' => $this->integer(25),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        // creates index for column `tenant_id`
        $this->createIndex(
            '{{%idx-asset_affiliation-tenant_id}}',
            '{{%asset_affiliation}}',
            'tenant_id'
        );

        // add foreign key for table `{{%tenant}}`
        $this->addForeignKey(
            '{{%fk-asset_affiliation-tenant_id}}',
            '{{%asset_affiliation}}',
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
        // drops foreign key for table `{{%tenant}}`
        $this->dropForeignKey(
            '{{%fk-asset_affiliation-tenant_id}}',
            '{{%asset_affiliation}}'
        );

        // drops index for column `tenant_id`
        $this->dropIndex(
            '{{%idx-asset_affiliation-tenant_id}}',
            '{{%asset_affiliation}}'
        );

        $this->dropTable('{{%asset_affiliation}}');
    }
}
