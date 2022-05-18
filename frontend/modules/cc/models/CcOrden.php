<?php

namespace frontend\modules\cc\models;

use Yii;

/**
 * This is the model class for table "{{%cc_cc}}".
 *
 * @property int $id
 * @property string $codigo
 * @property int $parent_id
 * @property string $descripcion
 * @property string $activo
 */
class CcOrden extends \common\models\base\modelBase
{
   public $booleanFields=['activo'];
   const PREFIJO_COD='7';
   const CODIGO_COLECTOR='O';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cc_cc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['codigo','descripcion'], 'required'],
            [['codigo'], 'unique'],
            [['parent_id'], 'integer'],
             [['codigo','descripcion','activo','esorden'], 'safe'],
                    [['parent_id'], 'valida_parent'],
             [['codigo'], 'valida_codigo'],
            [['codigo'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 50],
            //[['activo'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codigo' => Yii::t('app', 'Codigo'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'activo' => Yii::t('app', 'Activo'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CcCcQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CcOrdenQuery(get_called_class());
    }
    
    public function valida_parent($attribute, $params){
        if(!empty($this->id) && $this->id==$this->parent_id)
         $this->addError ($attribute,yii::t('base.errors','No puede ser hijo del mismo registro'));
    }
    
    public function valida_codigo($attribute, $params){
        if(!(substr($this->codigo,0,1)===self::PREFIJO_COD))
         $this->addError ('codigo',yii::t('base.errors','El código debe de comenzar con \'{prefijo}\'',['prefijo'=>self::PREFIJO_COD]));
    }
    
    public function beforeSave($insert) {
        if($insert)
        $this->esorden=self::CODIGO_COLECTOR;
        return parent::beforeSave($insert);
    }
}
