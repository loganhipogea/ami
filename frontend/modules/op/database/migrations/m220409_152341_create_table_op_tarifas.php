<?php
namespace frontend\modules\op\database\migrations;
use console\migrations\baseMigration;
class m220409_152341_create_table_op_tarifas extends baseMigration
{
    const TABLE='{{%op_planestarifa}}';
  // const TABLE_OS='{{%op_os}}';
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
            'codigo' =>  $this->string(4)->append($this->collateColumn()),
            'porc_dominical'=>$this->decimal(6,2),
            'porc_feriado'=>$this->decimal(6,2),
            'porc_nocturno'=>$this->decimal(6,2),
           'porc_localizacion'=>$this->decimal(6,2),
            'porc_refrigerio'=>$this->decimal(6,2),
           'porc_hextras'=>$this->decimal(6,2), 
           'nhoras'=>$this->integer(2),
           'hinicio_nocturno'=>$this->char(5),
           
          
            ],
           $this->collateTable());
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
