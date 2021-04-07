<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiKardexdepa]].
 *
 * @see SigiKardexdepa
 */
class SigiKardexdepaQuery extends \yii\db\ActiveQuery/*\frontend\modules\sigi\components\ActiveQueryScope*/
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiKardexdepa[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiKardexdepa|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
