<?php

namespace frontend\modules\cc\models;
USE frontend\modules\cc\components\ActiveQueryScopeColector;
/**
 * This is the ActiveQuery class for [[CcCc]].
 *
 * @see CcCc
 */
class CcOrdenQuery extends ActiveQueryScopeColector
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return CcCc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return CcCc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
