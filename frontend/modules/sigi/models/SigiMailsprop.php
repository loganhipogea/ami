<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_mailsprop}}".
 *
 * @property int $id
 * @property int $propietario_id
 * @property string $correo
 *
 * @property SigiPropietarios $propietario
 */
class SigiMailsprop extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_mailsprop}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['propietario_id', 'correo'], 'required'],
            [['propietario_id'], 'integer'],
            [['correo'], 'string', 'max' => 100],
            [['propietario_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiPropietarios::className(), 'targetAttribute' => ['propietario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'propietario_id' => Yii::t('app', 'Propietario ID'),
            'correo' => Yii::t('app', 'Correo'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropietario()
    {
        return $this->hasOne(SigiPropietarios::className(), ['id' => 'propietario_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiMailspropQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiMailspropQuery(get_called_class());
    }
}
