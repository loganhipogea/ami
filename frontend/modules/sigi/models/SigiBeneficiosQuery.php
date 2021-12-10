<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\components\ActiveQueryBeneficio;
/**
 * This is the ActiveQuery class for [[SigiCargos]].
 *
 * @see SigiCargos
 */
class SigiBeneficiosQuery extends ActiveQueryBeneficio
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiCargos[]|array
     */
    public function all($db = null)
    {
         
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiCargos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
