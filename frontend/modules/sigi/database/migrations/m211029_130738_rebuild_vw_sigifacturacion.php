<?php

use yii\db\Migration;
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211029_130738_rebuild_vw_sigifacturacion extends baseMigration
{
      const NAME_VIEW='{{%vw_sigi_facturecibo}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            return true;
   
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211029_130738_rebuild_vw_sigifacturacion cannot be reverted.\n";

        return false;
    }
    */
}
