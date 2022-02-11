<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatKardex]].
 *
 * @see MatKardex
 */
class MatKardexQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatKardex[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatKardex|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
