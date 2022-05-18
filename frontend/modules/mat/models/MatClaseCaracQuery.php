<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatClaseCarac]].
 *
 * @see MatClaseCarac
 */
class MatClaseCaracQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatClaseCarac[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatClaseCarac|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
