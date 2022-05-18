<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpTarifaHombre]].
 *
 * @see OpTarifaHombre
 */
class OpTarifaHombreQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpTarifaHombre[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpTarifaHombre|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
