<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m210627_173522_alter_table_docus_edif extends baseMigration
{
  
    const NAME_TABLE='{{%sigi_edificiodocu}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

$table=static::NAME_TABLE;
if(!$this->existsColumn($table,'finicio'))
     $this->addColumn($table, 'finicio', $this->char(10));  
 if(!$this->existsColumn($table,'ftermino'))
     $this->addColumn($table, 'ftermino', $this->char(10)); 
  
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'finicio'))
           $this->dropColumn($table,'finicio');
      if($this->existsColumn($table,'ftermino'))
           $this->dropColumn($table,'ftermino');
     
    }
}
