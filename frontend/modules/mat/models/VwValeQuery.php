<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[VwVale]].
 *
 * @see VwVale
 */
class VwValeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwVale[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwVale|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
