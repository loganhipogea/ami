<?php

namespace frontend\modules\mat\models;
use common\models\masters\Trabajadores;
use common\models\masters\Clipro;
use Yii;

/**
 * This is the model class for table "{{%mat_oc}}".
 *
 * @property int $id
 * @property string $numero
 * @property string $fecha
 * @property string $codpro
 * @property string $codtra
 * @property string $descripcion
 * @property string $textointerno
 * @property string $fpago
 * @property string $texto
 * @property string $codest
 * @property string $codmon
 * @property int $user_id
 *
 * @property FiSolpago[] $fiSolpagos
 * @property MatDetoc[] $matDetocs
 * @property Trabajadores $codtra0
 * @property Clipro $codpro0
 */
class MatOc extends \common\models\base\modelBase
{
    
    public $prefix='56';
    public $dateOrTimeFields=['fecha'];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_oc}}';
    }

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['numero'], 'required'],
            [['textointerno', 'texto'], 'string'],
            [['user_id'], 'integer'],
            [['numero', 'fecha'], 'string', 'max' => 10],
            [['codpro', 'codtra'], 'string', 'max' => 6],
            [['descripcion'], 'string', 'max' => 40],
            [['fpago', 'codest'], 'string', 'max' => 2],
            [['codmon'], 'string', 'max' => 3],
            [['codtra'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajadores::className(), 'targetAttribute' => ['codtra' => 'codigotra']],
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
            'fecha' => Yii::t('app', 'Fecha'),
            'codpro' => Yii::t('app', 'Codpro'),
            'codtra' => Yii::t('app', 'Codtra'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'textointerno' => Yii::t('app', 'Textointerno'),
            'fpago' => Yii::t('app', 'Fpago'),
            'texto' => Yii::t('app', 'Texto'),
            'codest' => Yii::t('app', 'Codest'),
            'codmon' => Yii::t('app', 'Codmon'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiSolpagos()
    {
       // return $this->hasMany(FiSolpago::className(), ['oc_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems()
    {
        return $this->hasMany(MatDetoc::className(), ['oc_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajadores::className(), ['codigotra' => 'codtra']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProveedor()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }

    /**
     * {@inheritdoc}
     * @return MatOcQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatOcQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
        if($insert){
            $this->numero=$this->correlativo('numero',10);
        }
        return parent::beforeSave($insert);
    }
}
