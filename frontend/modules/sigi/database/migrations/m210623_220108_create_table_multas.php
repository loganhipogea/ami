<?php
namespace frontend\modules\sigi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m210623_220108_create_table_multas extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const TABLE='{{%sigi_multas}}';
    const TABLE_UNIDADES='{{%sigi_unidades}}';
     const TABLE_EDIFICIOS='{{%sigi_edificios}}';
      const TABLE_PROPIETARIOS='{{%sigi_propietarios}}';
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
            'edificio_id' => $this->integer(11)->notNull(),
           'unidad_id' => $this->integer(11)->notNull(),
           'unidad_id_ocurrencia' => $this->integer(11)->notNull(),
            'propietario_id' => $this->integer(11)->notNull(),
           'fecha' =>  $this->char(10)->append($this->collateColumn()),
           'focurrencia' =>  $this->char(19)->append($this->collateColumn()),
             'activo' =>  $this->char(1)->append($this->collateColumn()), 
            'tipo' =>  $this->char(3)->append($this->collateColumn()), 
            'descripcion' =>  $this->string(40)->notNull()->append($this->collateColumn()), 
           'monto'=>$this->decimal(12,3)->notNull(),
           'detalle'=>$this->text()->append($this->collateColumn()), 
            //'monto_usd'=>$this->decimal(12,3),
           
           
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'edificio_id', static::TABLE_EDIFICIOS,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'unidad_id', static::TABLE_UNIDADES,'id');
       /*$this->addForeignKey($this->generateNameFk($table),
                    $table,'propietario_id', static::TABLE_PROPIETARIOS,'codigo');*/
        }
            $this->putCombo($table,'tipo', ['INFRACCION','REFACCION O PERJUICIO']);
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
