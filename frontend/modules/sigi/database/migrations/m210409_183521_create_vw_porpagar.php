<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\viewMigration;
use yii\db\Query;
use yii\db\Expression;
use frontend\modules\sigi\models\SigiMovimientosPre;
class m210409_183521_create_vw_porpagar extends viewMigration
{
    const NAME_VIEW='{{%mat_vw_vale}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
           $vista=static::NAME_VIEW;
        if($this->existsTable($vista)) {
        $this->dropView($vista);
        }
        $comando= $this->db->createCommand(); 
       
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.edificio_id', 'a.cargoedificio_id','a.glosa','a.fechadoc','e.despro','a.codpro',
      'sum(b.monto) as pagado','a.monto - sum(b.monto) as deuda',
      'd.descargo',
         ])
    ->from(['a'=>'{{%sigi_porpagar}}'])->
     innerJoin('{{%sigi_propago}} b', 'a.id=b.porpagar_id')->
     innerJoin('{{%sigi_cargosedificio}} c', 'c.id=a.cargoedificio_id')->          
      innerJoin('{{%sigi_cargos}} d', 'd.id=c.cargo_id')->  
     innerJoin('{{%clipro}} e', 'e.codpro=a.codpro')->andWhere(['a.activo'=>'1'])->
    // andWhere(['b.ingreso'=> SigiMovimientosPre::G_GRUPO_EGRESOS])->
     groupBy(['a.edificio_id', 'a.cargoedificio_id','a.glosa','a.fechadoc',
         'e.despro','a.codpro','d.descargo'])
        
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
