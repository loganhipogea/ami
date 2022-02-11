<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_kardex}}".
 *
 * @property int $id
 * @property int $detereq_id
 * @property string $fecha
 * @property string $cant
 */
class MatKardex extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_kardex}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detereq_id'], 'required'],
            [['detereq_id'], 'integer'],
            [['cant'], 'number'],
            [['fecha'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'detereq_id' => Yii::t('app', 'Detereq ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'cant' => Yii::t('app', 'Cant'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatKardexQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatKardexQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert)
        
        return parent::beforeSave($insert);
    }
}
