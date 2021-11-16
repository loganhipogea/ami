<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
use console\migrations\migrationMenu;
class m211116_190532_addopmenu12 extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        migrationMenu::insertOption('C. Beneficios',
                '/sigi/cargos/index-beneficios',
                'Gestion');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('C. Beneficios',
                '/sigi/cargos/index-beneficios',
                'Gestion');
        
    }

    
}
