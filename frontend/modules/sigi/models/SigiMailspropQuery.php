<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiMailsprop]].
 *
 * @see SigiMailsprop
 */
class SigiMailspropQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiMailsprop[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiMailsprop|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
