<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_atenciones}}".
 *
 * @property int $id
 * @property int $detreq_id
 * @property int $detvale_id
 * @property string $cant
 *
 * @property MatDetvale $detvale
 * @property MatDetreq $detreq
 */
class MatAtenciones extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_atenciones}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detreq_id', 'detvale_id', 'cant'], 'required'],
            [['detreq_id', 'detvale_id'], 'integer'],
            [['cant'], 'number'],
            [['detvale_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatDetvale::className(), 'targetAttribute' => ['detvale_id' => 'id']],
            [['detreq_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatDetreq::className(), 'targetAttribute' => ['detreq_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'detreq_id' => Yii::t('app', 'Detreq ID'),
            'detvale_id' => Yii::t('app', 'Detvale ID'),
            'cant' => Yii::t('app', 'Cant'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetvale()
    {
        return $this->hasOne(MatDetvale::className(), ['id' => 'detvale_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetreq()
    {
        return $this->hasOne(MatDetreq::className(), ['id' => 'detreq_id']);
    }

    /**
     * {@inheritdoc}
     * @return MatAtencionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatAtencionesQuery(get_called_class());
    }
}
