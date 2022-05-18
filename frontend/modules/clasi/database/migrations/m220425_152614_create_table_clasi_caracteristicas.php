<?php
namespace frontend\modules\clasi\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;

class m220425_152614_create_table_clasi_caracteristicas extends baseMigration
{
    const TABLE='{{%clasi_caracteristicas}}';
   const NAME_TABLE_CLASES='{{%clasi_clases}}';
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
           // 'id'=>$this->primaryKey(),
            'codigo' => $this->string(15)->notNull(),
            //'clase_id'=>$this->string(15)->notNull(),
            'descripcion' =>  $this->string(40)->append($this->collateColumn()),
             'user_id'=>$this->integer(4)
            ],
           $this->collateTable());
        $this->addPrimaryKey(
                $this->generateNameFk($table),
               $table,
                'codigo');      
      /*$this->addForeignKey($this->generateNameFk($table), $table,
              'clase_id', static::NAME_TABLE_CLASES,'codigo');
       */ }

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
