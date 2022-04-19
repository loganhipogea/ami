<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220418_145208_alter_table_kardex extends baseMigration
{

const TABLE='{{%mat_kardex}}';
   const TABLE_DETREQ='{{%mat_detreq}}';
    const TABLE_VALE='{{%mat_vale}}';
    // const TABLE_MOVIMIENTOS_BANCO='{{%sigi_movbanco}}';
    // const TABLE_TIPOMOV='{{%sigi_tipomov}}';
    //const TABLE_CARRERAS='{{%carreras}}';
    //const TABLE_CURSOS='{{%cursos}}';
    public function safeUp()
    {
 $table=static::TABLE;
        //var_dump(static::NAME_TABlE);die();
   if($this->existsTable($table)) {
       $this->dropTable($table);
       $this->createTable($table, [
            'id'=>$this->primaryKey(),
            'detreq_id'=>$this->integer(11),
             'detvale_id'=>$this->integer(11)->notNull(),
            'fecha' =>$this->char(10)->append($this->collateColumn()),
            'cant' =>$this->decimal(8,3),
           // 'valor' =>$this->decimal(10,3),
            'um' =>  $this->string(4)->append($this->collateColumn()),
            //'numero' => $this->string(10)->notNull(),
            //'fecha' =>  $this->char(10)->append($this->collateColumn()),
            //'fechasol' =>  $this->char(10)->append($this->collateColumn()),
           // 'codart' => $this->char(6)->notNull()->append($this->collateColumn()),
            //'codmov' => $this->char(3)->notNull()->append($this->collateColumn()),
           //'descripcion' =>  $this->string(40)->append($this->collateColumn()),
           // 'texto' =>  $this->text()->append($this->collateColumn()),
            //'codest' =>  $this->char(2)->append($this->collateColumn()),
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'detvale_id', static::TABLE_VALE,'id');
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
