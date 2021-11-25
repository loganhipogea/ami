<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211125_232210_alter_movim2 extends baseMigration
{
   const NAME_TABLE='{{%sigi_movimientos}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'doc_id')){
                $this->addColumn ($table, 'doc_id',$this->integer(11));
               
            } 
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'doc_id'))
        $this->dropColumn ($table, 'doc_id');
         
        
     }
}


