<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220327_162707_alter_table_mat_detvale extends baseMigration
{
    
    const TABLE='{{%mat_detvale}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'detreq_id')){         
           $this->addColumn($table, 'detreq_id', $this->integer(11));
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'detreq_id')){         
           $this->dropColumn($table, 'detreq_id');
        }
       
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M210601034325AlterTableMediaApps cannot be reverted.\n";

        return false;
    }
    */
}
