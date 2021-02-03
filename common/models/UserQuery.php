<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Useraudit]].
 *
 * @see Useraudit
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Useraudit[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Useraudit|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
