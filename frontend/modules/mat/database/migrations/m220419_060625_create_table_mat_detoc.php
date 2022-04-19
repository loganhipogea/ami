<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220419_060625_create_table_mat_detoc extends baseMigration
{
    const TABLE='{{%mat_detoc}}';
    const TABLE_OC='{{%mat_oc}}';
   const TABLE_DETREQ='{{%mat_detreq}}';
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
           'oc_id'=>$this->integer(11),
           'detreq_id'=>$this->integer(11),
           'item' =>  $this->char(4)->append($this->collateColumn()),
            'cant' => $this->decimal(8,3)->notNull(),
           'um' => $this->char(3)->append($this->collateColumn()),
            'codart' => $this->string(14)->append($this->collateColumn()),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
           'detalle' =>  $this->text()->append($this->collateColumn()),
              'punit' => $this->decimal(12,3)->notNull(),
            'punitimpuesto' => $this->decimal(12,3)->notNull(),
           'ptotal' => $this->decimal(12,3)->notNull(),
            'ptotalimpuesto' => $this->decimal(12,3)->notNull(),            
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'oc_id', static::TABLE_OC,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'detreq_id', static::TABLE_DETREQ,'id');
       /*$this->addForeignKey($this->generateNameFk($table),
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
