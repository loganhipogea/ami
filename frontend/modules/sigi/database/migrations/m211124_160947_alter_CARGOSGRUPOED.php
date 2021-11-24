<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m211124_160947_alter_CARGOSGRUPOED extends baseMigration
{
   const NAME_TABLE='{{%sigi_cargosgrupoedificio}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'egreso')){
                $this->addColumn ($table, 'egreso',$this->char(1));
               
            } 
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'egreso'))
        $this->dropColumn ($table, 'egreso');       
        
     }
}