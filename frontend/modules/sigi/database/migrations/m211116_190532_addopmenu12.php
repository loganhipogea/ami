<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
use console\migrations\menuMigration;
class m211116_190532_addopmenu12 extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        menuMigration::insertOption('C. Beneficios',
                '/sigi/cargos/index-beneficios',
                'Gestion');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        menuMigration::deleteOption('C. Beneficios',
                '/sigi/cargos/index-beneficios',
                'Gestion');
        return false;
    }

    
}
