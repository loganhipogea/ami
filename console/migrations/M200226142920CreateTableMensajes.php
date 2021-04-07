<?php
namespace console\migrations;
use yii\db\Migration;
/**
 * Class M200206173858CreateTableAccessDocus
 */
class M200226142920CreateTableMensajes extends baseMigration
{   
const NAME_TABLE='{{%mensajes}}';
 const NAME_TABLE_DOCUMENTOS='{{%documentos}}';
    public function safeUp()
    {
    /*   
 $table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table, [
             'id'=>$this->primaryKey(),
        'tipo' =>$this->char(1)->append($this->collateColumn()),
        'user_id' =>$this->integer(6),
        'fecha_hora' =>$this->string(19)->notNull()->append($this->collateColumn()),            
        'action' => $this->string(40)->append($this->collateColumn()),
        'id'=>$this->integer(11),
        'codocu' =>$this->string(6)->notNull()->append($this->collateColumn()), 
        
             ],$this->collateTable());
         $this->addForeignKey($this->generateNameFk($table), $table,
              'codocu', static::NAME_TABLE_DOCUMENTOS,'codocu');
           }*/
        return true;
    
    }

    
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       /* $table=static::NAME_TABLE; 
       if ($this->existsTable($table)){
            $this->dropTable($table);
        }*/
        return true;

    }
}
