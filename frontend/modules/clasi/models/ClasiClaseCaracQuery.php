<?php

namespace frontend\modules\clasi\models;

/**
 * This is the ActiveQuery class for [[ClasiClaseCarac]].
 *
 * @see ClasiClaseCarac
 */
class ClasiClaseCaracQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClasiClaseCarac[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClasiClaseCarac|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
