<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[VwOpLibro]].
 *
 * @see VwOpLibro
 */
class VwOpLibroQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return VwOpLibro[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return VwOpLibro|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
