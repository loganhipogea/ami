<?php

namespace frontend\modules\op\models;

use Yii;
use common\helpers\h;
/**
 * This is the model class for table "{{%op_documentos}}".
 *
 * @property int $id
 * @property int $proc_id
 * @property int $os_id
 * @property int $detos_id
 * @property string $descripcion
 * @property string $detalles
 * @property int $user_id
 * @property string $role
 *
 * @property OpOs $os
 * @property OpProcesos $proc
 * @property OpOsdet $detos
 */
class OpDocumentos extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_documentos}}';
    }
     public function behaviors()
         {
                return [
		
		'fileBehavior' => [
			'class' => '\common\behaviors\FileBehavior' 
                               ],
                    'auditoriaBehavior' => [
			'class' => '\common\behaviors\AuditBehavior' ,
                               ],
		
                    ];
        }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['proc_id', 'os_id', 'detos_id',], 'required'],
            [['proc_id', 'os_id', 'detos_id', 'user_id'], 'integer'],
            [['detalles'], 'string'],
            [['codocu'], 'safe'],
            [['descripcion'], 'string', 'max' => 40],
            [['role'], 'string', 'max' => 90],
            [['os_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOs::className(), 'targetAttribute' => ['os_id' => 'id']],
            [['proc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpProcesos::className(), 'targetAttribute' => ['proc_id' => 'id']],
            [['detos_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOsdet::className(), 'targetAttribute' => ['detos_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalles' => Yii::t('app', 'Detalles'),
            'user_id' => Yii::t('app', 'User ID'),
            'role' => Yii::t('app', 'Role'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOs()
    {
        return $this->hasOne(OpOs::className(), ['id' => 'os_id']);
    }
    
    public function getDocumento()
    {
        return $this->hasOne(\common\models\masters\Documentos::className(), ['codocu' => 'codocu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProc()
    {
        return $this->hasOne(OpProcesos::className(), ['id' => 'proc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetos()
    {
        return $this->hasOne(OpOsdet::className(), ['id' => 'detos_id']);
    }

    /**
     * {@inheritdoc}
     * @return OpDocumentosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpDocumentosQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->user_id=h::userId();
        }
        
        return parent::beforeSave($insert);
    }
}
