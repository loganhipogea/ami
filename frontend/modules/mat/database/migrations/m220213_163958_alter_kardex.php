<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220213_163958_alter_kardex extends baseMigration
{
    
    const TABLE='{{%mat_kardex}}';
   const TABLE_MAESTRO='{{%maestrocompo}}';
      public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'stock_id')){         
           $this->addColumn($table, 'stock_id', $this->integer(11));
        }
        if(!$this->existsColumn($table,'umreal')){         
           $this->addColumn($table, 'umreal', $this->char(4));
        }
        if(!$this->existsColumn($table,'codmov')){         
           $this->addColumn($table, 'codmov', $this->char(3));
        }
     if(!$this->existsColumn($table,'signo')){         
           $this->addColumn($table, 'signo', $this->integer(1));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'stock_id')){         
           $this->dropColumn($table, 'stock_id');
        }
        if($this->existsColumn($table,'umeral')){         
           $this->dropColumn($table, 'umreal');
        }
         if($this->existsColumn($table,'codmov')){         
           $this->dropColumn($table, 'codmov');
        }
         if($this->existsColumn($table,'signo')){         
           $this->dropColumn($table, 'signo');
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
