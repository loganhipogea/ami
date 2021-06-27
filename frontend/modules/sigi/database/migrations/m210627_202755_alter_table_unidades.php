<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m210627_202755_alter_table_unidades extends baseMigration
{
  
    const NAME_TABLE='{{%sigi_unidades}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

$table=static::NAME_TABLE;
if(!$this->existsColumn($table,'resumirprop'))
     $this->addColumn($table, 'resumirprop', $this->char(1));  
 
  
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'resumirprop'))
           $this->dropColumn($table,'resumirprop');
     
     
    }
}
