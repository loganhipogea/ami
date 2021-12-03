<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211203_235008_alter_tabke_movbanco extends baseMigration
{
   const NAME_TABLE='{{%sigi_movbanco}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'resumen_id')){
                $this->addColumn ($table, 'resumen_id',$this->integer(11));
               
            } 
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'resumen_id'))
        $this->dropColumn ($table, 'resumen_id');
         
        
     }
}