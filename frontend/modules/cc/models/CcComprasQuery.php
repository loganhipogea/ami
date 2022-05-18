<?php

namespace frontend\modules\cc\models;

/**
 * This is the ActiveQuery class for [[CcCompras]].
 *
 * @see CcCompras
 */
class CcComprasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CcCompras[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CcCompras|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
