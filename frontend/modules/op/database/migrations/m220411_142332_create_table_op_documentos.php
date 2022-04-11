<?php
namespace frontend\modules\op\database\migrations;
use console\migrations\baseMigration;
class m220411_142332_create_table_op_documentos extends baseMigration
{
     const TABLE='{{%op_documentos}}';
   // const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';
   const TABLE_DOCUMENTOS='{{%documentos}}';
  //const TABLE_DIRECCIONES='{{%direcciones}}';
 /// const TABLE_TRABAJADORES='{{%trabajadores}}';
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
           'proc_id'=>$this->integer(11)->notNull(),
           'os_id'=>$this->integer(11)->notNull(),
           'detos_id'=>$this->integer(11)->notNull(),
           'descripcion'=>$this->string(40)->append($this->collateColumn()),
           'detalles'=>$this->text()->append($this->collateColumn()),
            'user_id'=>$this->integer(4)->notNull(),
           'codocu'=>$this->char(3)->notNull(),
           'role'=>$this->string(90)->append($this->collateColumn()),  
            ],
           $this->collateTable());
             $this->addForeignKey($this->generateNameFk($table),
                    $table,'codocu', static::TABLE_DOCUMENTOS,'codocu');
                    }
                 $this->addForeignKey($this->generateNameFk($table),
                    $table,'os_id', static::TABLE_OS,'id');
                  $this->addForeignKey($this->generateNameFk($table),
                    $table,'detos_id', static::TABLE_OSDET,'id');
               $this->addForeignKey($this->generateNameFk($table),
                    $table,'proc_id', static::TABLE_PROCESOS,'id');
               
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
