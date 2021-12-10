<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[VwSigiColectores]].
 *
 * @see VwSigiColectores
 */
class VwSigiBeneficiosQuery extends \frontend\modules\sigi\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwSigiColectores[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwSigiColectores|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
