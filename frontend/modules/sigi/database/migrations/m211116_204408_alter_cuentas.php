<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211116_204408_alter_cuentas extends baseMigration
{
   
    const NAME_TABLE='{{%sigi_cuentas}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'fecult')){
                $this->addColumn ($table, 'fecult',$this->char(10));
               
            }
            
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'fecult'))
        $this->dropColumn ($table, 'fecult');
      
    }
}
