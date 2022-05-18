<?php

namespace frontend\modules\cc\models;

use Yii;

/**
 * This is the model class for table "{{%cc_vw_cc}}".
 *
 * @property int $id
 * @property string $codigo
 * @property string $descripcion
 * @property string $activo
 * @property int $parent_id
 * @property int $idp
 * @property string $codigop
 * @property string $descripcionb
 * @property string $activob
 * @property int $parent_idb
 */
class VwCc extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cc_vw_cc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'idp', 'parent_idb'], 'integer'],
            [['codigo', 'codigop'], 'string', 'max' => 10],
            [['descripcion', 'descripcionb'], 'string', 'max' => 50],
            [['activo', 'activob'], 'string', 'max' => 1],
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
            'descripcion' => Yii::t('app', 'Descripcion'),
            'activo' => Yii::t('app', 'Activo'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'idp' => Yii::t('app', 'Idp'),
            'codigop' => Yii::t('app', 'Codigop'),
            'descripcionb' => Yii::t('app', 'Descripcionb'),
            'activob' => Yii::t('app', 'Activob'),
            'parent_idb' => Yii::t('app', 'Parent Idb'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return VwCcQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VwCcQuery(get_called_class());
    }
}
