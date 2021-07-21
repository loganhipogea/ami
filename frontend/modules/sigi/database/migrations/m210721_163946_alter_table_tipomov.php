<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m210721_163946_alter_table_tipomov extends baseMigration
{ const NAME_TABLE='{{%sigi_tipomov}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'edificio_id'))
                //$this->alterColumn ($table, 'model',$this->string (100));
                $this->addColumn($table, 'edificio_id', $this->integer(11)); 
           
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'edificio_id'))
         $this->dropColumn ($table,'edificio_id');
                 
     
    }
}
