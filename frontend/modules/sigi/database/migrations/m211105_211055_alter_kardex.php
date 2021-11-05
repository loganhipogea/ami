<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211105_211055_alter_kardex extends baseMigration
{
    
    const NAME_TABLE='{{%sigi_kardexdepa}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'codedificio')){
                $this->addColumn ($table, 'codedificio',$this->string(8));
               
            }
            if(!$this->existsColumn($table,'codepa')){
                $this->addColumn ($table, 'codepa',$this->string(8));
               
            }
           
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'coddepa'))
        $this->dropColumn ($table, 'codepa');
       if($this->existsColumn($table,'codedificio'))
        $this->dropColumn ($table, 'codedificio'); 
      
    }
}
