<?php
namespace frontend\modules\mat\database\migrations;
use yii\db\Migration;
use console\migrations\baseMigration;
class m220310_185047_create_view_mat_req extends baseMigration
{
    const NAME_VIEW='{{%mat_vw_req}}';
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
     'a.id', 'a.codtra', 'a.numero','a.fechaprog','a.fechasol','a.descripcion',
      'b.req_id','b.codart','b.descripcion as descridetalle','b.cant','b.um','b.imptacion','b.tipim','b.item',
      'c.ap', 'c.am','c.nombres',
         ])
    ->from(['a'=>'{{%mat_req}}'])->
     innerJoin('{{%mat_detreq}} b', 'b.req_id=a.id')->
     innerJoin('{{%trabajadores}} c', 'c.codigotra=a.codtra')
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
