<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m220106_190224_table_voucher extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220106_190224_table_voucher cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220106_190224_table_voucher cannot be reverted.\n";

        return false;
    }
    */
}
