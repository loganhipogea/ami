<?php

namespace frontend\modules\sigi\models;

/**
 * This is the ActiveQuery class for [[Sigiporcobrar]].
 *
 * @see Sigiporcobrar
 */
class SigiporcobrarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/
public function init()
    {
      //var_dump(SigiUserEdificios::filterEdificios());die();
       //$this->andWhere([ 'in', 'codfac',['FIM','FIP'] ]);
      $this->alias('t')->andWhere(['ingreso'=>'1']);
        parent::init();
    }
    /**
     * {@inheritdoc}
     * @return Sigiporcobrar[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Sigiporcobrar|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
