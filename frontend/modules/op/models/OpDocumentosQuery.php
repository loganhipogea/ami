<?php

namespace frontend\modules\op\models;

/**
 * This is the ActiveQuery class for [[OpDocumentos]].
 *
 * @see OpDocumentos
 */
class OpDocumentosQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OpDocumentos[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OpDocumentos|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
