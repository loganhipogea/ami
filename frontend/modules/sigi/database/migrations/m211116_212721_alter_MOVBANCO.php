<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211116_212721_alter_MOVBANCO extends baseMigration
{  
    const NAME_TABLE='{{%sigi_movbanco}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
         $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'tipomov'))
        $this->dropColumn ($table, 'tipomov');
         
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'tipomov')){
                $this->addColumn ($table, 'tipomov',$this->char(3));
               
            } 
     }
}