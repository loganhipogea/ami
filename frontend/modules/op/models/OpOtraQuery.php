<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpOtra]].
 *
 * @see OpOtra
 */
class OpOtraQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpOtra[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpOtra|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
