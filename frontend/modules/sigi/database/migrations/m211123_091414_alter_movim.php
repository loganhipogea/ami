<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211123_091414_alter_movim extends baseMigration
{
   const NAME_TABLE='{{%sigi_movimientos}}';
   
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