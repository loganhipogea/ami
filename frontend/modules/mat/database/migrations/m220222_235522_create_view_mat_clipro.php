<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220222_235522_create_view_mat_clipro extends baseMigration
{
     const NAME_VIEW='{{%mat_vw_clipromat}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {         
         $vista=static::NAME_VIEW; 
        if($this->existsTable($vista))
         $this->dropView($vista);
        
                $comando= $this->db->createCommand();       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.despro', 'a.rucpro','a.alias','a.codpro',
      'b.codum','b.codart','b.descripcion',
      'c.tiempoentrega', 'c.precio','c.codmon',
         ])
    ->from(['a'=>'{{%clipro}}'])->
     innerJoin('{{%maestroclipro}} c', 'c.codpro=a.codpro')->
     innerJoin('{{%maestrocompo}} b', 'c.codart=b.codart')
                )->execute();
    
}
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210409_183521_create_vw_porpagar cannot be reverted.\n";

        return false;
    }
    */
}
