<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiImgedificio]].
 *
 * @see SigiImgedificio
 */
class SigiImgedificioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiImgedificio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiImgedificio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
