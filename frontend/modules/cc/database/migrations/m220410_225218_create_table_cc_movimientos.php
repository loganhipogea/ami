<?php
namespace frontend\modules\op\database\migrations;
use console\migrations\baseMigration;
class m220410_225218_create_table_cc_movimientos extends baseMigration
{
    const TABLE='{{%cc_movimientos}}';
    //const TABLE_TAREO='{{%op_tareo}}';
    const TABLE_OS='{{%op_os}}';
    const TABLE_PROCESOS='{{%op_procesos}}';
    const TABLE_OSDET='{{%op_osdet}}';
    const TABLE_DOCUMENTOS='{{%documentos}}';
    const TABLE_CLIPRO='{{%clipro}}';
    //const TABLE_TARIFAS='{{%op_planestarifa}}';
  //const TABLE_DIRECCIONES='{{%direcciones}}';
  //const TABLE_TRABAJADORES='{{%trabajadores}}';
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
            'codocu'=>$this->char(3)->append($this->collateColumn()),
            'codpro'=>$this->char(6)->append($this->collateColumn()),
           'descripcion'=>$this->string(40)->append($this->collateColumn()),
            'numero'=>$this->string(15)->append($this->collateColumn()),
           'serie'=>$this->string(15)->append($this->collateColumn()),
            'tipo' =>$this->char(1)->append($this->collateColumn()),
           'monto'=>$this->decimal(14,3),
           'montousd'=>$this->decimal(14,3),
           'user_id'=>$this->integer(11)->notNull(),
           'proc_id'=>$this->integer(11)->notNull(),
           'os_id'=>$this->integer(11)->notNull(),
           'detos_id'=>$this->integer(11)->notNull(),
           
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
                $this->addForeignKey($this->generateNameFk($table),
                    $table,'codpro', static::TABLE_CLIPRO,'codpro');
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
