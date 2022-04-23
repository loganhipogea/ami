<?php
namespace frontend\modules\op\database\migrations;
use console\migrations\baseMigration;
class m220410_222337_create_table_op_tareo extends baseMigration
{
    const TABLE='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';
  const TABLE_DIRECCIONES='{{%direcciones}}';
  // const TABLE_TRABAJADORES='{{%trabajadores}}';
    // const TABLE_MOVIMIENTOS_BANCO='{{%sigi_movbanco}}';
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
           'fecha' =>$this->char(10)->append($this->collateColumn()),
            'hinicio' =>$this->char(5)->append($this->collateColumn()),
            'hfin' =>$this->char(5)->append($this->collateColumn()),
           'descripcion'=>$this->string(40)->append($this->collateColumn()),
           'direcc_id'=>$this->integer(11)->notNull(),
           'proc_id'=>$this->integer(11)->notNull(),
           'os_id'=>$this->integer(11)->notNull(),
           'detos_id'=>$this->integer(11)->notNull(),
            'detalle'=>$this->text()->append($this->collateColumn()),
            ],
           $this->collateTable());
             $this->addForeignKey($this->generateNameFk($table),
                    $table,'direcc_id', static::TABLE_DIRECCIONES,'id');
                    }
                /* $this->addForeignKey($this->generateNameFk($table),
                    $table,'os_id', static::TABLE_OS,'id');
                  $this->addForeignKey($this->generateNameFk($table),
                    $table,'detos_id', static::TABLE_OSDET,'id');
               $this->addForeignKey($this->generateNameFk($table),
                    $table,'proc_id', static::TABLE_PROCESOS,'id')*/;
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
