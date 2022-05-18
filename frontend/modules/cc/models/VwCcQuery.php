<?php

namespace frontend\modules\cc\models;

/**
 * This is the ActiveQuery class for [[VwCc]].
 *
 * @see VwCc
 */
class VwCcQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwCc[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwCc|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
