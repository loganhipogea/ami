<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpTareo]].
 *
 * @see OpTareo
 */
class OpTareoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpTareo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpTareo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
