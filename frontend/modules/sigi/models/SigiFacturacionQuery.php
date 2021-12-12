<?php
use frontend\modules\sigi\models\VwSigiLecturas;
namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[SigiFacturacion]].
 *
 * @see SigiFacturacion
 */
class SigiFacturacionQuery extends \frontend\modules\sigi\components\ActiveQueryScope
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SigiFacturacion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SigiFacturacion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
    
}
