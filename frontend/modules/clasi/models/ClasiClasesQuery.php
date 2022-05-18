<?php

namespace frontend\modules\clasi\models;

/**
 * This is the ActiveQuery class for [[ClasiClases]].
 *
 * @see ClasiClases
 */
class ClasiClasesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClasiClases[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClasiClases|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
