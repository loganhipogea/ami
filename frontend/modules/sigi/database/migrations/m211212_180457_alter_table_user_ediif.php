<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211212_180457_alter_table_user_ediif extends baseMigration
{
   const NAME_TABLE='{{%sigi_user_edificios}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'unidad_id')){
                $this->addColumn ($table, 'unidad_id',$this->integer(11));
               
            } 
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'unidad_id'))
        $this->dropColumn ($table, 'unidad_id');
         
        
     }
}