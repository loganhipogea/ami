<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpOsdet]].
 *
 * @see OpOsdet
 */
class OpOsdetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpOsdet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpOsdet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
