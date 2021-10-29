<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211024_212643_altersigiproppago extends baseMigration
{
   const NAME_TABLE='{{%sigi_propago}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'codbanco')){
                $this->addColumn ($table, 'codbanco',$this->string(10));
               
            }
            
            if(!$this->existsColumn($table,'codmon')){
                $this->addColumn ($table, 'codmon',$this->string(4));
               
            }
            
            if($this->existsColumn($table,'nivel')){
                $this->alterColumn($table, 'nivel',$this->char(1));               
            }
            if($this->existsColumn($table,'cuenta')){
                $this->alterColumn($table, 'cuenta',$this->string(30));               
            }
            if($this->existsColumn($table,'cci')){
                $this->alterColumn($table, 'cci',$this->string(30));               
            }
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'codbanco'))
        $this->dropColumn ($table, 'codbanco');
      
      if($this->existsColumn($table,'codmon'))
        $this->dropColumn ($table, 'codmon');
    }
}
