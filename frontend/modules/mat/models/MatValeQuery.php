<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatVale]].
 *
 * @see MatVale
 */
class MatValeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVale[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVale|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
