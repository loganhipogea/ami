<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpOs]].
 *
 * @see OpOs
 */
class OpOsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpOs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpOs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
