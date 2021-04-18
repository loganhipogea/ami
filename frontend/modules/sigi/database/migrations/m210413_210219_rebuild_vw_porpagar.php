<?php
namespace frontend\modules\sigi\database\migrations;
use console\migrations\viewMigration;
use yii\db\Query;
use yii\db\Expression;
class m210413_210219_rebuild_vw_porpagar extends viewMigration
{
    const NAME_VIEW='{{%sigi_vw_porpagar}}';
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
        $subquery=(new Query())->select(['idop'])->from(['{{%sigi_movimientos}}'])->andWhere(['activo'=>'1']) ;
        $comando->createView($vista,
                (new \yii\db\Query())
    ->select([
      'a.id','a.edificio_id', 'a.cargoedificio_id','a.glosa','a.fechadoc','e.despro','a.codpro',
      'sum(b.monto) as pagado','a.monto - sum(b.monto) as deuda',
      'd.descargo',
         ])
    ->from(['a'=>'{{%sigi_porpagar}}'])->
     innerJoin('{{%sigi_movimientospago}} b', 'a.id=b.pago_id')->
     innerJoin('{{%sigi_cargosedificio}} c', 'c.id=a.cargoedificio_id')->          
      innerJoin('{{%sigi_cargos}} d', 'd.id=c.cargo_id')->
     innerJoin('{{%clipro}} e', 'e.codpro=a.codpro')->andWhere(['activo'=>'1'])->
     groupBy(['a.edificio_id', 'a.cargoedificio_id','a.glosa','a.fechadoc',
         'e.despro','a.codpro','d.descargo'])
        ->union(
            (new \yii\db\Query())
                ->select([
                    'a.id','a.edificio_id', 'a.cargoedificio_id','a.glosa','a.fechadoc',
                    'e.despro','a.codpro',new Expression('0 as pagado'),'a.monto as deuda', 'd.descargo'
                    ])->from(['a'=>'{{%sigi_porpagar}}'])->    
     innerJoin('{{%sigi_cargosedificio}} c', 'c.id=a.cargoedificio_id')->          
      innerJoin('{{%sigi_cargos}} d', 'd.id=c.cargo_id')->
     innerJoin('{{%clipro}} e', 'e.codpro=a.codpro')->
                andWhere(['not in','a.id',$subquery])->createCommand()->rawSql
                 )
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

}
