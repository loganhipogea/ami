<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpProcesos]].
 *
 * @see OpProcesos
 */
class OpProcesosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpProcesos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpProcesos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
