<?php

namespace console\migrations;
use console\migrations\baseMigration;


/**
 * Class m190406_044824_create_table_direcciones
 */
class m211024_205101_alter_clipro extends baseMigration
{
    
    const NAME_TABLE='{{%clipro}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'codbanco')){
                $this->addColumn ($table, 'codbanco',$this->string(10));
               
            }
            if(!$this->existsColumn($table,'cci')){
                $this->addColumn ($table, 'cci',$this->string(20));
               
            }
            if(!$this->existsColumn($table,'cuenta')){
                $this->addColumn ($table, 'cuenta',$this->string(30));
               
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
       if($this->existsColumn($table,'cci'))
        $this->dropColumn ($table, 'cci'); 
       if($this->existsColumn($table,'cuenta'))
        $this->dropColumn ($table, 'cuenta');
      
     
    }
}
