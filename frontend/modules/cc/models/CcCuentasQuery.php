<?php

namespace frontend\modules\cc\models;

/**
 * This is the ActiveQuery class for [[SigiCuentas]].
 *
 * @see SigiCuentas
 */
class CcCuentasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiCuentas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiCuentas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
