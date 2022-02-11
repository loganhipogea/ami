<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220205_203617_create_table_detreq extends baseMigration
{
    const TABLE='{{%mat_detreq}}';
   const TABLE_REQ='{{%mat_req}}';
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
            'req_id'=>$this->integer(11),
              'item' =>$this->char(4)->append($this->collateColumn()),
            'codart' =>$this->string(14)->append($this->collateColumn()),
           'descripcion' =>$this->string(40)->append($this->collateColumn()),
           'cant' =>$this->decimal(8,3),
            'um' =>  $this->string(4)->append($this->collateColumn()),
           'imptacion' =>  $this->string(14)->append($this->collateColumn()),
           'tipim' =>  $this->char(1)->append($this->collateColumn()),
            'texto' =>  $this->text()->append($this->collateColumn()),
            'activo' =>$this->char(1)->append($this->collateColumn()),
         
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'req_id', static::TABLE_REQ,'id');
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
