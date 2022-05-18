<?php

namespace frontend\modules\clasi\models;

use Yii;

/**
 * This is the model class for table "{{%clasi_clases}}".
 *
 * @property string $codigo
 * @property string $descripcion
 * @property int $user_id
 *
 * @property ClasiCaracteristicas[] $clasiCaracteristicas
 * @property ClasiClaseCarac[] $clasiClaseCaracs
 */
class ClasiClases extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clasi_clases}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['user_id'], 'integer'],
            [['codigo'], 'string', 'max' => 15],
            [['descripcion'], 'string', 'max' => 40],
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codigo' => Yii::t('app', 'Codigo'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
   

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClasiClaseCaracs()
    {
        return $this->hasMany(ClasiClaseCarac::className(), ['clase_id' => 'codigo']);
    }

    /**
     * {@inheritdoc}
     * @return ClasiClasesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClasiClasesQuery(get_called_class());
    }
}
