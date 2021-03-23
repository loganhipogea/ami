<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiMovimientos]].
 *
 * @see SigiMovimientos
 */
class SigiMovimientosPreQuery extends \yii\db\ActiveQuery //\frontend\modules\sigi\components\ActiveQueryScopePreMov
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiMovimientos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiMovimientos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
