<?php

namespace frontend\modules\clasi\models;

/**
 * This is the ActiveQuery class for [[ClasiCarac]].
 *
 * @see ClasiCarac
 */
class ClasiCaracQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClasiCarac[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClasiCarac|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
