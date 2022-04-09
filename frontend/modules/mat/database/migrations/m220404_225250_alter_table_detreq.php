<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220404_225250_alter_table_detreq extends baseMigration
{
    
    const TABLE='{{%mat_detreq}}';
   //const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'proc_id')){         
           $this->addColumn($table, 'proc_id', $this->integer(11));
        }
        if(!$this->existsColumn($table,'os_id')){         
           $this->addColumn($table, 'os_id', $this->integer(11));
        }
        if(!$this->existsColumn($table,'detos_id')){         
           $this->addColumn($table, 'detos_id', $this->integer(11));
        }
         if(!$this->existsColumn($table,'ultimo')){         
           $this->addColumn($table, 'ultimo', $this->integer(11));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'proc_id')){         
           $this->dropColumn($table, 'proc_id');
        }
       if($this->existsColumn($table,'os_id')){         
           $this->dropColumn($table, 'os_id');
        }
        if($this->existsColumn($table,'detos_id')){         
           $this->dropColumn($table, 'detos_id');
        }
        if($this->existsColumn($table,'ultimo')){         
           $this->dropColumn($table, 'ultimo');
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
