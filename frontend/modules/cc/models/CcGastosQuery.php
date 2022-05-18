<?php

namespace frontend\modules\cc\models;

/**
 * This is the ActiveQuery class for [[CcGastos]].
 *
 * @see CcGastos
 */
class CcGastosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CcGastos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CcGastos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
