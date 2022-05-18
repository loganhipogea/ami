<?php

namespace frontend\modules\op\models;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%op_libro}}".
 *
 * @property int $id
 * @property string $hinicio
 * @property string $hfin
 * @property int $proc_id
 * @property int $user_id
 * @property int $os_id
 * @property int $detos_id
 * @property string $descripcion
 * @property string $detalle
 */
class OpLibro extends \common\models\ModelCali
{
   
     public function behaviors() {
        return [
           /* 'AccessDownloadBehavior' => [
                'class' => AccessDownloadBehavior::className()
            ],*/
            /*'fileBehavior' => [
                'class' => FileBehavior::className()
            ],*/
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
            'caliBehavior' => [
                'class' => '\common\behaviors\CaliBehavior',
            ],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_libro}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_id', 'os_id', 'detos_id'], 'required'],
            [['tareo_id','tipo'], 'safe'],
            [['proc_id', 'user_id', 'os_id', 'detos_id'], 'integer'],
            [['detalle'], 'string'],
            [['hinicio', 'hfin'], 'string', 'max' => 5],
            [['descripcion'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'hinicio' => Yii::t('app', 'Hinicio'),
            'hfin' => Yii::t('app', 'Hfin'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return OpLibroQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpLibroQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert)
        $this->user_id=h::userId();
        return parent::beforeSave($insert);
    }
    
    
}
