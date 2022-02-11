<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatStock]].
 *
 * @see MatStock
 */
class MatStockQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatStock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatStock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
