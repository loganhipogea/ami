<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiSanciones]].
 *
 * @see SigiSanciones
 */
class SigiSancionesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiSanciones[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiSanciones|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
