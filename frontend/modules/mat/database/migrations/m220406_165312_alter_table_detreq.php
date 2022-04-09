<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220406_165312_alter_table_detreq extends  baseMigration
{
    
    const TABLE='{{%mat_detreq}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'user_id')){         
           $this->addColumn($table, 'user_id', $this->integer(5));
        }
        if(!$this->existsColumn($table,'fechaprog')){         
           $this->addColumn($table, 'fechaprog', $this->char(10));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
       
        
        if($this->existsColumn($table,'user_id')){         
           $this->dropColumn($table, 'user_id');
        }
         if($this->existsColumn($table,'fechaprog')){         
           $this->dropColumn($table, 'fechaprog');
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
