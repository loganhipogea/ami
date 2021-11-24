<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiCargosgrupoedificio]].
 *
 * @see SigiCargosgrupoedificio
 */
class SigiBenegrupoedificioQuery extends \frontend\modules\sigi\components\ActiveQueryBeneficio
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiCargosgrupoedificio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiCargosgrupoedificio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
