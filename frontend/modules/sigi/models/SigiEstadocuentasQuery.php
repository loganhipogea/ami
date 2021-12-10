<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\VwSigiResuestadocuentaQuery;
/**
 * This is the ActiveQuery class for [[SigiEstadocuentas]].
 *
 * @see SigiEstadocuentas
 */
class SigiEstadocuentasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
    public function init(){
        $this->alias('t');
        return parent::init();
    }
    /**
     * {@inheritdoc}
     * @return SigiEstadocuentas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiEstadocuentas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    public function movimientosAgrupado(){
       return $this->select( [
           'SUM(a.monto) as monto', 'a.tipomov','t.mes','c.descripcion',
            'a.ingreso','t.anio'])
               ->innerJoin('{{%sigi_movimientos}} a', 'a.resumen_id=t.id')
              ->innerJoin('{{%sigi_cargosgrupoedificio}} c', 'a.tipomov=c.codgrupo')
            ->groupBy(['a.tipomov','t.mes','a.ingreso','t.anio']);
        
    }
    
    public function resumenByEdificios(){
       return $this->select( [
           'max(t.codigo) as monto',
           'e.codigo','t.mes','t.id','t.saldmesant','t.ingresos','t.egresos','t.saldfinal','t.saldecuenta','t.salddif'
           ])->innerJoin('{{%sigi_edificios}} e','e.id=t.edificio_id')
             ->groupBy([
            'e.codigo','t.mes', 't.saldmesant','t.ingresos','t.egresos','t.saldfinal','t.saldecuenta','t.salddif'
           ]);
        
    }
}
