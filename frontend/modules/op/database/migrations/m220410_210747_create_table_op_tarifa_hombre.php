<?php
namespace frontend\modules\op\database\migrations;
use console\migrations\baseMigration;
class m220410_210747_create_table_op_tarifa_hombre extends baseMigration
{
    const TABLE='{{%op_tarifa_hombre}}';
  const TABLE_TARIFAS='{{%op_planestarifa}}';
  const TABLE_CLIPRO='{{%clipro}}';
   //const TABLE_PROCESOS='{{%op_procesos}}';
   
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
           'tarifa_id'=>$this->integer(11)->notNull(),
           'codtra'=>$this->char(6)->append($this->collateColumn()),
            'costohora'=>$this->decimal(6,2),
           
           
            ],
           $this->collateTable());
        $this->addForeignKey($this->generateNameFk($table),
                    $table,'codtra', static::TABLE_CLIPRO,'codigotra');
        }
        $this->addForeignKey($this->generateNameFk($table),
                    $table,'tarifa_id', static::TABLE_TARIFAS,'id');
        
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
