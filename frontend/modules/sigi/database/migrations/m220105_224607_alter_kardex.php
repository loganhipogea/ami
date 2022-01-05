<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;
class m220105_224607_alter_kardex extends baseMigration
{
   const NAME_TABLE='{{%sigi_kardexdepa}}';
   
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {       
        $table=static::NAME_TABLE;
            if(!$this->existsColumn($table,'voucher_id')){
                $this->addColumn ($table, 'voucher_id',$this->integer(11));
               
            } 
               
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
         $table=static::NAME_TABLE; 
      if($this->existsColumn($table,'voucher_id'))
        $this->dropColumn ($table, 'voucher_id');
         
        
     }
}