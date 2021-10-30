<?php

use yii\db\Migration;
namespace frontend\modules\sigi\database\migrations;
//use yii\db\Migration;
use console\migrations\baseMigration;
class m211029_130738_rebuild_vw_sigifacturacion extends baseMigration
{
      const NAME_VIEW='{{%vw_sigi_facturecibo}}';
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
        //$subquery=(new Query())->select(['pago_id'])->from(['{{%sigi_movimientospago}}'])->andWhere(['activo'=>'1']) ;
        $comando->createView($vista,
                (new \yii\db\Query())         
    ->select([
      'a.kardex_id', 'a.dias','a.resumido','a.grupocobranza','a.nuevoprop','a.codmon',
      'a.id',$expresion,'a.consumototal','a.numerorecibo',
      'a.montototal','a.participacion as particmed','a.codsuministro','a.aacc','a.delta',
      'a.lectura','a.cuentaspor_id','a.edificio_id','a.unidad_id','a.colector_id',
       'a.grupo_id','a.monto','a.igv','a.grupounidad','a.grupofacturacion','a.facturacion_id',
        'a.mes','a.anio','a.identidad','a.unidades',
        'b.fecha','b.fvencimiento','b.descripcion','b.detalles',
        'c.nombre as nombreedificio','c.codigo','c.direccion',
        'd.numero','d.nombre','d.area','d.participacion',
        'f.descargo','f.codcargo',
        'g.codgrupo','g.descripcion as desgrupo',
        'h.numero as numerodepa','h.nombre as nombredepa','h.area as areadepa',
        'h.participacion as participaciondepa','mx.simbolo'
         ])
    ->from(['a'=>'{{%sigi_detfacturacion}}'])->
     innerJoin('{{%sigi_facturacion}} b', 'a.facturacion_id=b.id')->
     innerJoin('{{%sigi_edificios}} c', 'c.id=b.edificio_id')->  
      innerJoin('{{%sigi_unidades}} d', 'd.id=a.grupounidad_id')->   
      innerJoin('{{%sigi_unidades}} h', 'h.id=a.unidad_id')->
      innerJoin('{{%sigi_cargosedificio}} e', 'e.id=a.colector_id')-> 
       innerJoin('{{%sigi_cargos}} f', 'e.cargo_id=f.id')->   
        innerJoin('{{%sigi_cargosgrupoedificio}} g', 'a.grupo_id=g.id')->
         innerJoin('{{%monedas}} mx', 'mx.codmon=a.codmon')->createCommand()->rawSql
          )->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211029_130738_rebuild_vw_sigifacturacion cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211029_130738_rebuild_vw_sigifacturacion cannot be reverted.\n";

        return false;
    }
    */
}
