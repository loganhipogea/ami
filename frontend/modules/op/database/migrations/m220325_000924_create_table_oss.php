<?php
namespace frontend\modules\op\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220325_000924_create_table_oss extends baseMigration
{
    const TABLE='{{%op_os}}';
   const TABLE_CLIPRO='{{%clipro}}';
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
            'proc_id'=>$this->integer(11)->notNull(),
            'numero' => $this->string(9)->notNull(),
            'fechaprog' =>  $this->char(10)->append($this->collateColumn()),
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
            'codtra' =>  $this->char(6)->append($this->collateColumn()),
            
            ],
           $this->collateTable());
        $this->addForeignKey($this->generateNameFk($table),
                    $table,'codpro', static::TABLE_CLIPRO,'codpro');
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
