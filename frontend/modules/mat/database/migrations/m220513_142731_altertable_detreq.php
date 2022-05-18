<?php
namespace frontend\modules\mat\database\migrations;
use console\migrations\baseMigration;
class m220513_142731_altertable_detreq extends baseMigration
{
    /**
     * {@inheritdoc}
     */
   const TABLE='{{%mat_detreq}}';
     public function safeUp()
    {
        $table=static::TABLE;
        if(!$this->existsColumn($table,'tipo')){         
           $this->addColumn($table, 'tipo', $this->char(3));
        }
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::TABLE;
        if($this->existsColumn($table,'tipo')){         
           $this->dropColumn($table, 'tipo');
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
