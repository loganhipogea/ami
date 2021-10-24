<?php
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211024_163511_altermigration extends baseMigration
{
    
    const NAME_TABLE='{{%sigi_kardexdepa}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'historico')){
                $this->addColumn ($table, 'historico',$this->char (1));
               (new \yii\db\Query)
    ->createCommand()->update($table,['historico'=>'0'])
  ->execute();
            }
                
                //$this->addColumn($table, 'id_anterior', $this->integer(11)); 
           
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
