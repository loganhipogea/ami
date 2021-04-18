<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m210413_191918_alter_table_tipo_movimientos extends baseMigration
{
  
    const NAME_TABLE='{{%sigi_tipomov}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

$table=static::NAME_TABLE;
if(!$this->existsColumn($table,'signo'))
     $this->addColumn($table, 'signo', $this->integer(1));  
 
    
  if(!$this->existsColumn($table,'conciliable'))
     $this->addColumn($table, 'conciliable', $this->char(1));  
 
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'signo'))
           $this->dropColumn($table,'signo');
      if($this->existsColumn($table,'conciliable'))
           $this->dropColumn($table,'conciliable');
     
    }
}
