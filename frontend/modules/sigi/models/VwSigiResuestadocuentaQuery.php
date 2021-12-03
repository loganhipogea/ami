<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[VwSigiResuestadocuenta]].
 *
 * @see VwSigiResuestadocuenta
 */
class VwSigiResuestadocuentaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwSigiResuestadocuenta[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwSigiResuestadocuenta|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
