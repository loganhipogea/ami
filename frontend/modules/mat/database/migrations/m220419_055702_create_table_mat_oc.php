<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220419_055702_create_table_mat_oc extends baseMigration
{
    const TABLE='{{%mat_oc}}';
   const TABLE_TRABAJADORES='{{%trabajadores}}';
    const TABLE_CLIPRO='{{%clipro}}';
    
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
            'numero' => $this->string(10)->notNull(),
            'fecha' =>  $this->char(10)->append($this->collateColumn()),
            //'fechasol' =>  $this->char(10)->append($this->collateColumn()),
            'codpro' =>  $this->char(6)->append($this->collateColumn()),
            'codtra' =>  $this->char(6)->append($this->collateColumn()),
           'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'textointerno' =>  $this->text()->append($this->collateColumn()),
            'fpago' =>  $this->char(2)->append($this->collateColumn()),
           'texto' =>  $this->text()->append($this->collateColumn()),
            'codest' =>  $this->char(2)->append($this->collateColumn()),
            'codmon' =>  $this->char(3)->append($this->collateColumn()),
           'user_id'=>$this->integer(4)
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'codtra', static::TABLE_TRABAJADORES,'codigotra');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'codpro', static::TABLE_CLIPRO,'codpro');
       /*$this->addForeignKey($this->generateNameFk($table),
                    $table,'tipomov', static::TABLE_TIPOMOV,'codigo');*/
        $this->putCombo($table, 'fpago', [
                  'CONTADO',
                   'FACTURA 30 DIAS',
                  'FACTURA 15 DIAS',
                  'FACTURA 45 DIAS',
                   'CHEQUE DIFERIDO',
                 
                  ]);
       
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
