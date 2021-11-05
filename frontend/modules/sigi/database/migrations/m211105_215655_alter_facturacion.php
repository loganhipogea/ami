<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211105_215655_alter_facturacion extends baseMigration
{
   
    const NAME_TABLE='{{%sigi_facturacion}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'historico')){
                $this->addColumn ($table, 'historico',$this->char(1));
               
            }
            
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'historico'))
        $this->dropColumn ($table, 'historico');
      
    }
}
