<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211024_211518_alterclipro extends baseMigration
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
            if(!$this->existsColumn($table,'codmon')){
                $this->addColumn ($table, 'codmon',$this->string(4));
               
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
      if($this->existsColumn($table,'codmon'))
        $this->dropColumn ($table, 'codmon');
    }
}
