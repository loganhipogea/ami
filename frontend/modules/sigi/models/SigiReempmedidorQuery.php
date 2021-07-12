<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiReempmedidor]].
 *
 * @see SigiReempmedidor
 */
class SigiReempmedidorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiReempmedidor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiReempmedidor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
