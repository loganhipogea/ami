<?php
namespace frontend\modules\access\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m191224_162617_create_permissOIn_models extends baseMigration
{
       const NAME_TABLE='{{%access_model_permiso}}';
    /*const NAME_TABLE='{{%sta_citas}}';
     const NAME_TABLE_TALLERESDET='{{%sta_talleresdet}}';
      const NAME_TABLE_TALLERES='{{%sta_talleres}}';
     const NAME_TABLE_TRABAJADORES='{{%trabajadores}}';*/
   //const NAME_TABLE_ALUMNO='{{%sta_alu}}';
    /*const NAME_TABLE_CURSOS='{{%sta_materias}}';
     const NAME_TABLE_PERIODOS='{{%sta_periodos}}';*/
    public function safeUp()
    {
       /*$table=static::NAME_TABLE;
if(!$this->existsTable($table)) {
    $this->createTable($table,  [
         'id'=>$this->primaryKey(),
       // 'aluriesgo_id'=>$this->integer(11)->notNull(),
        'modelo'=>$this->string(200)->append($this->collateColumn())->notNull(),
        'permiso'=>$this->string(200)->append($this->collateColumn()),
        'activo'=>$this->char(1)->append($this->collateColumn())->notNull(),
        ],$this->collateTable());
  
            } */
        return true;
 }

public function safeDown()
    {
     /*$table=static::NAME_TABLE;
       if($this->existsTable($table)) {
            $this->dropTable($table);
        }*/
    return true;

    }

}