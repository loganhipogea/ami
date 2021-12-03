<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211203_210646_alter_tabke_movi extends baseMigration
{
   const NAME_TABLE='{{%sigi_movimientos}}';
   
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