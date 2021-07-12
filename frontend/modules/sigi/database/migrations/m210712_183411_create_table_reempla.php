<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m210712_183411_create_table_reempla extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const TABLE='{{%sigi_reempmedidor}}';
    const TABLE_SUMINISTROS='{{%sigi_suministros}}';
    /* const TABLE_EDIFICIOS='{{%sigi_edificios}}';
      const TABLE_PROPIETARIOS='{{%sigi_propietarios}}';*/
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
            'suministro_id_ant' => $this->integer(11)->notNull(),
           'ultima_lectura' => $this->decimal(12,4)->notNull(),
           'fecha_ultima_lectura' =>  $this->char(10)->append($this->collateColumn()),
          'fecha_reemplazo' =>  $this->char(10)->append($this->collateColumn()),
           'codsuministro_actual'=>$this->string(12)->append($this->collateColumn()),
           'lectura_actual'=>$this->decimal(12,4),
           //'focurrencia' =>  $this->char(19)->append($this->collateColumn()),
             'detalle'=>$this->text()->append($this->collateColumn()), 
            //'monto_usd'=>$this->decimal(12,3),
           
           
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'suministro_id_ant', static::TABLE_SUMINISTROS,'id');
      
        }
           // $this->putCombo($table,'tipo', ['INFRACCION','REFACCION O PERJUICIO']);
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
