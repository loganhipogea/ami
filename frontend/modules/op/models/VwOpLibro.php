<?php

namespace frontend\modules\op\models;

use Yii;

/**
 * This is the model class for table "{{%op_vw_libro}}".
 *
 * @property int $id
 * @property string $fecha
 * @property string $descripcion
 * @property int $direcc_id
 * @property int $os_id
 * @property int $proc_id
 * @property int $detos_id
 * @property string $descridetalle
 */
class VwOpLibro extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_vw_libro}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'direcc_id', 'os_id', 'proc_id', 'detos_id'], 'integer'],
            [['direcc_id', 'os_id', 'proc_id', 'detos_id'], 'required'],
            [['fecha'], 'string', 'max' => 10],
            [['descripcion', 'descridetalle'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'direcc_id' => Yii::t('app', 'Direcc ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'descridetalle' => Yii::t('app', 'Descridetalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwOpQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwOpLibroQuery(get_called_class());
    }
}
