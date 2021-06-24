<?php
namespace frontend\modules\sigi\database\migrations;
use backend\components\Installer;
use console\migrations\baseMigration;
class m210624_182752_add_item_menu extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      Installer::createMenuSingle(['/sigi/porpagar/index-multa'=>'Infracciones'],
             'Administradores');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      Installer::deleteMenuSingle(['/sigi/porpagar/index-multa'=>'Infracciones'],
             'Administradores');  
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210624_182752_add_item_menu cannot be reverted.\n";

        return false;
    }
    */
}
