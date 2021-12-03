<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211202_163303_sigi_estados_cuenta extends baseMigration
{
    /**
     * {@inheritdoc}
     */
    const TABLE='{{%sigi_estadocuentas}}';
    const TABLE_CUENTAS='{{%sigi_cuentas}}';
    const TABLE_EDIFICIOS='{{%sigi_edificios}}';
      
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
            'edificio_id' => $this->integer(11)->notNull(),
            'cuenta_id' => $this->integer(11)->notNull(),
           'saldmesant' => $this->decimal(12,4),
           'ingresos' => $this->decimal(12,4),
           'egresos' => $this->decimal(12,4),
           'saldfinal' => $this->decimal(12,4),
           'saldecuenta' => $this->decimal(12,4),
            'salddif' => $this->decimal(12,4),
            'mes' =>  $this->char(2)->append($this->collateColumn())->notNull(),
           'anio' =>  $this->char(4)->append($this->collateColumn())->notNull(),
           'codigo' =>  $this->char(6),
           'estado' =>  $this->char(4)->append($this->collateColumn())->notNull(),
            ],
           $this->collateTable());
       
       $this->addForeignKey($this->generateNameFk($table),
                    $table,'edificio_id', static::TABLE_EDIFICIOS,'id');
                    
        }
        $this->addForeignKey($this->generateNameFk($table),
                    $table,'cuenta_id', static::TABLE_CUENTAS,'id');
                    
        }
           // $this->putCombo($table,'tipo', ['INFRACCION','REFACCION O PERJUICIO']);
    

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
?>
