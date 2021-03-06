<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiCargosgrupoedificio]].
 *
 * @see SigiCargosgrupoedificio
 */
class SigiCargosgrupoedificioQuery extends \frontend\modules\sigi\components\ActiveQueryScope
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
        $this->alias('t')->andWhere(['egreso'=>'1']);
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
