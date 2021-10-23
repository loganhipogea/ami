<?php
namespace frontend\modules\import\database\migrations;
use console\migrations\baseMigration;


/**
 * Class m211023_180358_alter_importtable
 */
class m211023_180358_alter_importtable extends baseMigration
{
    const NAME_TABLE='{{%import_cargamasiva}}';
        public function safeUp()
    {
        $table=static::NAME_TABLE;
        if(!$this->existsColumn($table,'delimitador')){         
           $this->addColumn($table, 'delimitador', $this->char(1));
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE;
        if($this->existsColumn($table,'delimitador')){         
           $this->dropColumn($table, 'delimitador');
        }
        
    }
    
}
