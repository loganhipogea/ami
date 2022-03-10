<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatVwReq]].
 *
 * @see MatVwReq
 */
class MatVwReqQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatVwReq[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatVwReq|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
