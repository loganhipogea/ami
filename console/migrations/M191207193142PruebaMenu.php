<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M191207193142PruebaMenu
 */
class M191207193142PruebaMenu extends baseMigration
{
     const NAME_TABLE='{{%menu}}';
    public function safeUp()
    {
         /** Agregando una columna a la tabla Direcciones
         * con su respectiva llave foranes
         */
       /* $table=static::NAME_TABLE;
        //var_dump($table);die();
      if($this->existsTable($table)) {
          if(!$this->existsColumn($table,'icon')){         
            $this->addColumn($table,
                 'icon', 
                 $this->string(35)->append($this->collateColumn())
                 );
        }
        (new \yii\db\Query)
    ->createCommand()->update($table, ['icon' => 'circle'],'id >0')->execute();
   
      }*/
        
        return true;    
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      /* $table=static::NAME_TABLE;
        if($this->existsColumn($table,'icon')){ 
            $this->dropColumn($table,'icon');
        }*/
        return true;
       
       
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M190929152929AlterTableMenu cannot be reverted.\n";

        return false;
    }
    */
}
