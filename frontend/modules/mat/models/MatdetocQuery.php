<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatDetoc]].
 *
 * @see MatDetoc
 */
class MatdetocQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatDetoc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatDetoc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
