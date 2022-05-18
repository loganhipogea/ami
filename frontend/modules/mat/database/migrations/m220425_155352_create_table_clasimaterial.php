<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220425_155352_create_table_clasimaterial extends baseMigration
{
    const TABLE='{{%mat_clasificacion}}';
    const TABLE_CLASES_CARACTERISTICAS='{{%clasi_clase_carac}}';
    const TABLE_MAESTRO_COMPO='{{%maestrocompo}}';
   //const TABLE_DETREQ='{{%mat_detreq}}';
    //const TABLE_CLIPRO='{{%clipro}}';
    
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
           'clasificacion_id'=>$this->string(31)->append($this->collateColumn())->notNull(),
           'codart' => $this->string(14)->append($this->collateColumn()),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
            'valor' => $this->string(200)->append($this->collateColumn()),
            'valor_numerico' => $this->decimal(12,4),            
           'codum'=>$this->string(4),
            'user_id'=>$this->integer(4),
            ],
           $this->collateTable());
       
     
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'clasificacion_id', static::TABLE_CLASES_CARACTERISTICAS,'codigo');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'codart', static::TABLE_MAESTRO_COMPO,'codart');
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
