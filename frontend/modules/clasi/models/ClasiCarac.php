<?php

namespace frontend\modules\clasi\models;

use Yii;

/**
 * This is the model class for table "{{%clasi_caracteristicas}}".
 *
 * @property string $codigo
 * @property string $clase_id
 * @property string $descripcion
 * @property int $user_id
 *
 * @property ClasiClases $clase
 * @property ClasiClaseCarac[] $clasiClaseCaracs
 */
class ClasiCarac extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clasi_caracteristicas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['user_id'], 'integer'],
            [['codigo',], 'string', 'max' => 15],
            [['descripcion'], 'string', 'max' => 40],
            [['codigo'], 'unique'],
            //[['clase_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClasiClases::className(), 'targetAttribute' => ['clase_id' => 'codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => Yii::t('app', 'Codigo'),
            //'clase_id' => Yii::t('app', 'Clase ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

   

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getClasiClaseCaracs()
    {
        return $this->hasMany(ClasiClaseCarac::className(), ['carac_id' => 'codigo']);
    }*/

    /**
     * {@inheritdoc}
     * @return ClasiCaracQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClasiCaracQuery(get_called_class());
    }
}
