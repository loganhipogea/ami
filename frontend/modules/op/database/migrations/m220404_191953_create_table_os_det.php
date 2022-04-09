<?php
namespace frontend\modules\op\database\migrations;
use console\migrations\baseMigration;
class m220404_191953_create_table_os_det extends baseMigration
{
    const TABLE='{{%op_osdet}}';
   const TABLE_OS='{{%op_os}}';
   const TABLE_PROCESOS='{{%op_procesos}}';
   
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
            'proc_id'=>$this->integer(11),
            'os_id'=>$this->integer(11),
            'finicio'=>$this->char(19)->append($this->collateColumn()),
           'termino'=>$this->char(19)->append($this->collateColumn()),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
           'item'=>$this->char(3)->append($this->collateColumn()),
            'emplazamiento'=>$this->char(1)->append($this->collateColumn()),
           'codtra'=>$this->char(6)->append($this->collateColumn()),
            'tipo'=>$this->char(1)->append($this->collateColumn()),
           'tarifa'=>$this->char(1)->append($this->collateColumn()),
            'detalle' =>  $this->text()->append($this->collateColumn()),
            'valor' =>  $this->decimal(12,3),
            'numero' => $this->string(9)->notNull(),
           'interna'=>$this->char(1)->append($this->collateColumn()),
            /*'fechaprog' =>  $this->char(10)->append($this->collateColumn()),
           'fechaini' =>  $this->char(10)->append($this->collateColumn()),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),         
            //'numoc' =>  $this->string(14)->append($this->collateColumn()),
           'codpro' =>  $this->char(6)->append($this->collateColumn()),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'tipo' =>  $this->char(1)->append($this->collateColumn()),
            'codestado' =>  $this->char(2)->append($this->collateColumn()),
            'textocomercial' =>  $this->text()->append($this->collateColumn()),
            'textointerno' =>  $this->text()->append($this->collateColumn()),
            'textotecnico' =>  $this->text()->append($this->collateColumn()),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),*/
            
            ],
           $this->collateTable());
        $this->addForeignKey($this->generateNameFk($table),
                    $table,'os_id', static::TABLE_OS,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'proc_id', static::TABLE_PROCESOS,'id');
       /*$this->addForeignKey($this->generateNameFk($table),
                    $table,'pago_id', static::TABLE_PORPAGAR,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'tipomov', static::TABLE_TIPOMOV,'codigo');*/
        }

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
