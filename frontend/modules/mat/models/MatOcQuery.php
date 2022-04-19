<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatOc]].
 *
 * @see MatOc
 */
class MatOcQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatOc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatOc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
