<?php
namespace frontend\modules\op\database\migrations;
use console\migrations\baseMigration;
class m220424_184046_alter_table_tarifa extends baseMigration
{
    
    const TABLE='{{%op_tarifa_hombre}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'activo')){         
           $this->addColumn($table, 'activo', $this->char(1));
        }
        
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'activo')){         
           $this->dropColumn($table, 'activo');
        }
        
       
    }
   
}
