<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatDetvale]].
 *
 * @see MatDetvale
 */
class MatDetvaleQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatDetvale[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatDetvale|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
