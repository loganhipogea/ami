<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220207_171845_create_table_mat_stock extends baseMigration
{const TABLE='{{%mat_stock}}';
   const TABLE_MATERIALES='{{%maestrocompo}}';
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
              'codart'=>$this->string(14)->unique()->notNull()->append($this->collateColumn()),
            'cant' =>$this->decimal(8,3),
            'um' =>  $this->string(4)->append($this->collateColumn()),
           'ubicacion' =>$this->string(14)->append($this->collateColumn()),
            'cantres' =>$this->decimal(8,3),
             'codal' =>  $this->string(4)->append($this->collateColumn()),
            'valor' =>$this->decimal(10,3),
           'lastmov'=> $this->string(10)->append($this->collateColumn()),
         
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'codart', static::TABLE_MATERIALES,'codart');
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
