<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiBasePresupuesto]].
 *
 * @see SigiBasePresupuesto
 */
class SigiBasePresupuestoQuery extends \frontend\modules\sigi\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiBasePresupuesto[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiBasePresupuesto|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
