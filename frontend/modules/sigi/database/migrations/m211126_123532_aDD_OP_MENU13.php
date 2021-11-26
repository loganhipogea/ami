<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
use console\migrations\migrationMenu;
class m211126_123532_aDD_OP_MENU13 extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        migrationMenu::insertOption('Docs por Cobrar',
                '/sigi/porpagar/index-cobrar',
                'Administradores');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Docs por Cobrar',
                '/sigi/porpagar/index-cobrar',
                'Administradores');
        
    }

    
}



