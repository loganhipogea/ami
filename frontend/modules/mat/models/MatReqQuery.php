<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatReq]].
 *
 * @see MatReq
 */
class MatReqQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatReq[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatReq|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
