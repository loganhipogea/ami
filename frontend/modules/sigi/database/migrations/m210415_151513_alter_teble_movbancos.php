<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;/**
 * Class m210413_165548_alter_table_movimientos
 */
class m210415_151513_alter_teble_movbancos extends baseMigration
{
  
    const NAME_TABLE='{{%sigi_movbanco}}';
   
    public function safeUp()
    {

   $table=static::NAME_TABLE;
if(!$this->existsColumn($table,'tipomov'))
     $this->addColumn($table, 'tipomov', $this->char(3)->append($this->collateColumn()));  
 
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'tipomov'))
           $this->dropColumn($table,'tipomov');
     
    }
}
