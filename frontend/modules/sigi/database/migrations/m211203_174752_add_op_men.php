<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\migrationMenu;
use console\migrations\baseMigration;
class m211203_174752_add_op_men extends baseMigration
 
   {  /* {@inheritdoc}
     */
    public function safeUp()
    {
        migrationMenu::insertOption('Periodos',
                 '/sigi/estadocu/index',
                'Tesorería');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Periodos',
                '/sigi/estadocu/index',
                'Tesorería');
        
    }

    
}



