<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\components\ActiveQueryMovPagos;
/**
 * This is the ActiveQuery class for [[VwKardexPagos]].
 *
 * @see VwKardexPagos
 */
class VwKardexPagosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwKardexPagos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwKardexPagos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
