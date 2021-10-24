<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211024_193213_alterporpagar extends baseMigration
{
    
    const NAME_TABLE='{{%sigi_porpagar}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'ingreso')){
                $this->addColumn ($table, 'ingreso',$this->char (1));
               
            }
            if(!$this->existsColumn($table,'unidad_id')){
                $this->addColumn ($table, 'unidad_id',$this->integer(11));
               
            }
                
                //$this->addColumn($table, 'id_anterior', $this->integer(11)); 
           
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'ingreso'))
        $this->dropColumn ($table, 'ingreso');
       if($this->existsColumn($table,'unidad_id'))
        $this->dropColumn ($table, 'unidad_id');          
     
    }
}
