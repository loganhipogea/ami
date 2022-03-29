<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220327_160732_create_table_mt_atenciones extends baseMigration
{
    const TABLE='{{%mat_atenciones}}';
   const TABLE_DETVALE='{{%mat_detvale}}';
    const TABLE_DETREQ='{{%mat_detreq}}';
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
            'detreq_id' => $this->integer(11)->notNull(),
            'detvale_id' => $this->integer(11)->notNull(),
            'cant' =>  $this->decimal(10,4)->notNull(),           
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'detreq_id', static::TABLE_DETREQ,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'detvale_id', static::TABLE_DETVALE,'id');
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
