<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211024_222549_altersigiporpagar extends baseMigration
{
   const NAME_TABLE='{{%sigi_porpagar}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'en_recibo')){
                $this->addColumn ($table, 'en_recibo',$this->char(1));
               
            }
          (new \yii\db\Query)
    ->createCommand()->update($table,['en_recibo'=>'0'])
  ->execute();
             
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'en_recibo'))
        $this->dropColumn ($table, 'en_recibo');
    }
}
