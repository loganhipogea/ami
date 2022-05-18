<?php

namespace frontend\modules\cc\models;
use frontend\modules\cc\interfaces\MovimientosInterface;
/**
 * This is the ActiveQuery class for [[CcMovimientos]].
 *
 * @see CcMovimientos
 */
class CcMovimientosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CcMovimientos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CcMovimientos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
