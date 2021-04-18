<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m210413_210218_create_table_movimientospagos extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const TABLE='{{%sigi_movimientospago}}';
    const TABLE_PORPAGAR='{{%sigi_porpagar}}';
     const TABLE_MOVIMIENTOS_BANCO='{{%sigi_movbanco}}';
     const TABLE_TIPOMOV='{{%sigi_tipomov}}';
    //const TABLE_CARRERAS='{{%carreras}}';
    //const TABLE_CURSOS='{{%cursos}}';
    public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if(!$this->existsTable($table)) {
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
             'idop' => $this->integer(20)->notNull(),
            'edificio_id' => $this->integer(11)->notNull(),
           'cuenta_id' => $this->integer(11)->notNull(),
           'fechaprog' =>  $this->char(10)->append($this->collateColumn()), 
            'tipomov' =>  $this->char(3)->notNull()->append($this->collateColumn()), 
            'glosa' =>  $this->string(40)->notNull()->append($this->collateColumn()), 
           'monto'=>$this->decimal(12,3)->notNull(),
            'monto_usd'=>$this->decimal(12,3),
           'igv'=>$this->decimal(8,3),
            'activo' =>  $this->char(1)->append($this->collateColumn()),
            'pago_id' => $this->integer(20)->notNull(),
            'ingreso' =>  $this->char(1)->append($this->collateColumn()),
           
            ],
           $this->collateTable());
       
      /* $this->addForeignKey($this->generateNameFk($table),
                    $table,'idop', static::TABLE_MOVIMIENTOS_BANCO,'id');*/
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
