<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m210811_204727_alter_table_movbancos extends baseMigration
{ const NAME_TABLE='{{%sigi_movbanco}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'detalle'))
                $this->addColumn($table, 'detalle', $this->text()); 
           
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'detalle'))
         $this->dropColumn ($table,'detalle');
                 
     
    }
}
