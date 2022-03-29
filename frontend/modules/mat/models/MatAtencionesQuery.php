<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatAtenciones]].
 *
 * @see MatAtenciones
 */
class MatAtencionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatAtenciones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatAtenciones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
