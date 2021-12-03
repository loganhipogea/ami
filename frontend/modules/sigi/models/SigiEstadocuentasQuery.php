<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiEstadocuentas]].
 *
 * @see SigiEstadocuentas
 */
class SigiEstadocuentasQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiEstadocuentas[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiEstadocuentas|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
