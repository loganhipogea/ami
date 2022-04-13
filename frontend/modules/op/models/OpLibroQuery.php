<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpLibro]].
 *
 * @see OpLibro
 */
class OpLibroQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpLibro[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpLibro|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
