<?php
namespace frontend\modules\cc\database\migrations;
use console\migrations\baseMigration;
class m220517_135515_view_cc extends baseMigration
{
     const NAME_VIEW='{{%cc_vw_cc}}';
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
      'a.id', 'a.codigo','a.descripcion','a.activo','a.parent_id',
      'b.id as idp', 'b.codigo as codigop','b.descripcion as descripcionb','a.activo as activob','a.parent_id as parent_idb',      
         ])
    ->from(['a'=>'{{%cc_cc}}'])->
     innerJoin('{{%cc_cc}} b', 'a.id=b.parent_id')     
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
