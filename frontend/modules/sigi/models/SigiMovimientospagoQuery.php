<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiMovimientospago]].
 *
 * @see SigiMovimientospago
 */
class SigiMovimientospagoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiMovimientospago[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiMovimientospago|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
