<?php

namespace frontend\modules\mat\models;

/**
 * This is the ActiveQuery class for [[MatDetreq]].
 *
 * @see MatDetreq
 */
class MatDetreqQuery extends \yii\db\ActiveQuery
{
    
    public function init(){
        
    }
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MatDetreq[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MatDetreq|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    
    
}
