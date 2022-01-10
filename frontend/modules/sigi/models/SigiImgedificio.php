<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\behaviors\FileBehavior;
use Yii;

/**
 * This is the model class for table "{{%sigi_imgedificio}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $comentario
 */
class SigiImgedificio extends \common\models\base\modelBase {
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_imgedificio}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id'], 'required'],
            [['edificio_id'], 'integer'],
            [['comentario'], 'string'],
        ];
    }
 public function behaviors() {
        return [
            
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
            
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'edificio_id' => Yii::t('app', 'Edificio ID'),
            'comentario' => Yii::t('app', 'Comentario'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SigiImgedificioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiImgedificioQuery(get_called_class());
    }
}
