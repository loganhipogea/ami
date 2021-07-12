<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m210712_165538_alter_table_suministr extends baseMigration
{
  
    const NAME_TABLE='{{%sigi_suministros}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

                $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'id_anterior'))
                $this->addColumn($table, 'id_anterior', $this->integer(11)); 
            
            if(!$this->existsColumn($table,'delta_anterior'))
                $this->addColumn($table, 'delta_anterior', $this->decimal(12,4)); 




    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'id_anterior'))
           $this->dropColumn($table,'id_anterior');
     if($this->existsColumn($table,'delta_anterior'))
           $this->dropColumn($table,'delta_anterior');
     
    }
}
