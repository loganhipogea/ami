<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m210719_152633_create_table_mails_prop extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const TABLE='{{%sigi_mailsprop}}';
    const TABLE_PROPIETARIOS='{{%sigi_propietarios}}';
    /* const TABLE_EDIFICIOS='{{%sigi_edificios}}';
      const TABLE_PROPIETARIOS='{{%sigi_propietarios}}';*/
     //const TABLE_MOVIMIENTOS_BANCO='{{%sigi_movbanco}}';
    // const TABLE_TIPOMOV='{{%sigi_tipomov}}';
    //const TABLE_CARRERAS='{{%carreras}}';
    //const TABLE_CURSOS='{{%cursos}}';
    public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
             //'idop' => $this->integer(20)->notNull(),
            'propietario_id' => $this->integer(11)->notNull(),
            'correo' =>$this->string(100)->append($this->collateColumn())->notNull(),
          
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'propietario_id', static::TABLE_PROPIETARIOS,'id');
      
        }
           // $this->putCombo($table,'tipo', ['INFRACCION','REFACCION O PERJUICIO']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
if ($this->existsTable(static::TABLE)) {
            $this->dropTable(static::TABLE);
        }
    }

    
}
