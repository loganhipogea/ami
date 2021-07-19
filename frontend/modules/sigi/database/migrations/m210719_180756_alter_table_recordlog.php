<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m210719_180756_alter_table_recordlog extends baseMigration
{
  
    const NAME_TABLE='{{%activerecordlog}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if($this->existsColumn($table,'model'))
                $this->alterColumn ($table, 'model',$this->string (100));
                //$this->addColumn($table, 'id_anterior', $this->integer(11)); 
           
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'model'))
         $this->alterColumn ($table, 'model',$this->string (45));
                 
     
    }
}
