<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;/**
 * Class m210413_165548_alter_table_movimientos
 */
class m210413_165548_alter_table_movimientos extends baseMigration
{
  
    const NAME_TABLE='{{%sigi_movimientos}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

$table=static::NAME_TABLE;
if(!$this->existsColumn($table,'ingreso'))
     $this->addColumn($table, 'ingreso', $this->char(1)->append($this->collateColumn()));  
 
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'ingreso'))
           $this->dropColumn($table,'ingreso');
     
    }
}
