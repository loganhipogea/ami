<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211127_221103_alter_cuentaspor extends baseMigration
{
   const NAME_TABLE='{{%sigi_cuentaspor}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'anexado')){
                $this->addColumn ($table, 'anexado',$this->char(1));
               
            } 
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'anexado'))
        $this->dropColumn ($table, 'anexado');
         
        
     }
}


