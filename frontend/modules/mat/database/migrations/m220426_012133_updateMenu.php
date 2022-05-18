<?php
namespace frontend\modules\mat\database\migrations;
use console\migrations\baseMigration;
use console\migrations\migrationMenu;
class m220426_012133_updateMenu extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        migrationMenu::insertOption('Operaciones', null,null);
        migrationMenu::insertOption('Control', '/op/tareo/index','Operaciones');
        migrationMenu::insertOption('Procesos', '/op/proc/index','Operaciones');
        
        migrationMenu::insertOption('Materiales', null,null);
        migrationMenu::insertOption('Requerimientos', '/mat/mat/index','Materiales');
        migrationMenu::insertOption('Activos', '/bigitems/activos/index','Materiales');
         migrationMenu::insertOption('Stock', '/mat/mat/index-stock','Materiales');
        //migrationMenu::insertOption('Activos', '/bigitems/activos/index','Materiales');
         migrationMenu::insertOption('Compras', null,null);
        migrationMenu::insertOption('Ordenes de compra', '/mat/mat/oc','Compras');

         
    } 
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        migrationMenu::deleteOption('Control', '/op/tareo/index','Operaciones');
        migrationMenu::deleteOption('Procesos', '/op/proc/index','Operaciones');
        migrationMenu::deleteOption('Operaciones', null,null);
        
        
      
        migrationMenu::deleteOption('Requerimientos', '/mat/mat/index','Materiales');
        migrationMenu::deleteOption('Activos', '/bigitems/activos/index','Materiales');
         migrationMenu::deleteOption('Requerimientos', '/mat/mat/index-stock','Materiales');
           migrationMenu::deleteOption('Materiales', null,null);
        //migrationMenu::insertOption('Activos', '/bigitems/activos/index','Materiales');
       
        migrationMenu::deleteOption('Ordenes de compra', '/mat/mat/oc','Compras');
          migrationMenu::deleteOption('Compras', null,null);

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220426_012133_updateMenu cannot be reverted.\n";

        return false;
    }
    */
}
