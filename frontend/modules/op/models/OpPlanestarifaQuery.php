<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpPlanestarifa]].
 *
 * @see OpPlanestarifa
 */
class OpPlanestarifaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpPlanestarifa[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpPlanestarifa|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
