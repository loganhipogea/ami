<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\baseMigration;

/**
 * Class m210413_191919_fill_table_tipomovimientos
 */
class m210413_191919_fill_table_tipomovimientos extends baseMigration
{
   const NAME_TABLE='{{%sigi_tipomov}}';
 //const NAME_TABLE_CENTROS='{{%centros}}';
    public function safeUp()
    {
        self::deleteData();
            \Yii::$app->db->createCommand()->
             batchInsert(static::NAME_TABLE,
             $this->fields(), $this->getData())->execute();
    }

    public function safeDown()
    { static::deleteData();
    }

    
   private static function  getData(){
        //$campos=['codocu','codocupadre','desdocu','clase','tipo','abreviatura'];
        return [
            ['100', 'COBRANZAS' ,1],
            ['200', 'ITF' ,-1], 
            ['300', 'COMISIONES' ,-1],
            ['400', 'INTERESES' ,1], 
            ['500', 'PAGOS' ,-1],
            ];
    }
    
    
    private static function  fields(){
        return  ['codigo','descripcion','signo'];
    }
    
    private static function  deleteData(){        
        
          (new \yii\db\Query)
    ->createCommand()
    ->delete(self::NAME_TABLE)
    ->execute();
       
    }
}
    
  