<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220419_061949_create_table_fi_solpago extends baseMigration
{
    const TABLE='{{%fi_solpago}}';
    const TABLE_OC='{{%mat_oc}}';
    const TABLE_DOC='{{%documentos}}';
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
           'oc_id'=>$this->integer(11),
           'numero' => $this->string(14)->append($this->collateColumn()),
            'fecha' =>  $this->char(10)->append($this->collateColumn()),
           'fechapago' =>  $this->char(10)->append($this->collateColumn()),
            'porcentaje' =>  $this->integer(3)->notNull(),
           'descripcion' =>  $this->string(40)->append($this->collateColumn()),
           'detalle' =>  $this->text()->append($this->collateColumn()),
           'monto' => $this->decimal(12,3)->notNull(),
            'codmon' => $this->char(3)->append($this->collateColumn()),
            'codocu' => $this->char(3)->append($this->collateColumn()), 
            'numdocu' => $this->string(20)->append($this->collateColumn()),
            'codestado' => $this->char(2)->append($this->collateColumn()),
            'user_id'=>$this->integer(4),
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'oc_id', static::TABLE_OC,'id');
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'codocu', static::TABLE_DOC,'codocu');
      
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
