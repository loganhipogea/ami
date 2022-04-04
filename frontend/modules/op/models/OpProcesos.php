<?php

namespace frontend\modules\op\models;
use common\models\masters\Clipro;
use common\behaviors\FileBehavior;
use common\helpers\h;
use Yii;

/**
 * This is the model class for table "{{%op_procesos}}".
 *
 * @property int $id
 * @property string $numero
 * @property string $fechaprog
 * @property string $fechaini
 * @property string $numoc
 * @property string $codpro
 * @property string $descripcion
 * @property string $tipo
 * @property string $codestado
 * @property string $textocomercial
 * @property string $textointerno
 * @property string $textotecnico
 *
 * @property Clipro $codpro0
 */
class OpProcesos extends \common\models\base\modelBase
{
    
    public $prefijo = '3';
     public $dateorTimeFields = [
        'fechaprog' => self::_FDATE,
        'fechaini' => self::_FDATE,
        //'ftermino' => self::_FDATETIME
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_procesos}}';
    }

    
     public function behaviors() {
        return [
           
            'fileBehavior' => [
                'class' => FileBehavior::className()
            ],
            'auditoriaBehavior' => [
                'class' => '\common\behaviors\AuditBehavior',
            ],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fechaprog','descripcion','tipo','codpro'], 'required'],
            [['textocomercial', 'textointerno', 'textotecnico'], 'string'],
            [['numero', 'codpro'], 'string', 'max' => 6],
            [['fechaprog', 'fechaini'], 'string', 'max' => 10],
            [['numoc'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 40],
            [['tipo'], 'string', 'max' => 1],
            [['codestado'], 'string', 'max' => 2],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'numero' => Yii::t('app', 'Numero'),
            'fechaprog' => Yii::t('app', 'F. Prog'),
            'fechaini' => Yii::t('app', 'F. Inicio'),
            'numoc' => Yii::t('app', 'Nº Oc'),
            'codpro' => Yii::t('app', 'Cliente'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'tipo' => Yii::t('app', 'Tipo'),
            'codestado' => Yii::t('app', 'Estado'),
            'textocomercial' => Yii::t('app', 'Texto Comercial'),
            'textointerno' => Yii::t('app', 'Texto Interno'),
            'textotecnico' => Yii::t('app', 'Texto Técnico'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }

    
    public function getOrdenes()
    {
        return $this->hasMany(OpOs::className(), ['proc_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return OpProcesosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpProcesosQuery(get_called_class());
    }
    
     public function beforeSave($insert) {
       // yii::error('funcion beforeSave  '.date('Y-m-d H:i:s'));
        if ($insert) {
            
            $this->numero = $this->correlativo('numero');
           
        }else{
          
        }

        //$this->resolveDuration();
        return parent::beforeSave($insert);
    }
}
