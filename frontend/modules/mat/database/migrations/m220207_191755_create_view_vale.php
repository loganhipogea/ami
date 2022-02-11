<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220207_191755_create_view_vale extends baseMigration
{
   const NAME_VIEW='{{%mat_vw_vale}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           $vista=static::NAME_VIEW;
        if(!$this->existsTable($vista)) {
         $this->db->createCommand()->dropView($vista);
        
        $comando= $this->db->createCommand(); 
       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.numero', 'a.fecha','a.codmov','a.codpro',
      'b.cant','b.um','b.codart','b.item','b.um',
      'c.descripcion',
         ])
    ->from(['a'=>'{{%mat_vale}}'])->
     innerJoin('{{%mat_detvale}} b', 'a.id=b.vale_id')->
     innerJoin('{{%maestrocompo}} c', 'c.codart=b.codart')
                )->execute();
    }
}
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->db->createCommand()->dropView($vista);
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
