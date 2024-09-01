<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tenant}}`.
 */
class m240830_115144_create_tenant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tenant}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'principle_tenant_name' => $this->string(),
            'house_number' => $this->string(),
            'cell_number' => $this->string(15),
            'billing_email_address' => $this->string(50),
            'id_number' => $this->string(50),
            'agreed_rent_payable' => $this->integer(),
            'agreed_water_rate' => $this->integer(),
            'has_signed_tenancy_agreement' => $this->boolean(),
            'created_at' => $this->integer(),
            'update_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tenant}}');
    }
}
