<?php

use yii\db\Migration;

/**
 * Class m220106_190851_create_table_voucxher
 */
class m220106_190851_create_table_voucxher  extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const TABLE='{{%sigi_vouchers}}';
   // const TABLE_SUMINISTROS='{{%sigi_suministros}}';
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
            'user_id' => $this->integer(11)->notNull(),           
           'fecha' =>  $this->char(19)->append($this->collateColumn()),
                    
            ],
           $this->collateTable());
     
      
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
