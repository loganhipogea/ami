<?php

namespace frontend\modules\sigi\models;
use frontend\modules\sigi\models\Edificios;
use common\helpers\timeHelper;
use frontend\modules\sigi\models\VwSigiResuestadocuenta;
use frontend\modules\sigi\models\VwSigiResuestadocuentaQuery;
use Yii;
class SigiEstadocuentas extends \common\models\base\modelBase
{
   const ESTADO_CREADO='CREA';
   const ESTADO_CERRADO='CERR';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_estadocuentas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id',  'mes','anio','cuenta_id'], 'required'],
            [['edificio_id', 'cuenta_id'], 'integer'],
            [['saldmesant', 'ingresos', 'egresos', 'saldfinal', 'saldecuenta', 'salddif'], 'number'],
            [['mes'], 'string', 'max' => 2],
            [['anio'], 'string', 'max' => 4],
            [['anio'], 'unique', 'targetAttribute' => ['anio','mes','edificio_id']],
           
            [['edificio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Edificios::className(), 'targetAttribute' => ['edificio_id' => 'id']],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => SigiCuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
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
            'cuenta_id' => Yii::t('app', 'Cuenta ID'),
            'saldmesant' => Yii::t('app', 'Saldmesant'),
            'ingresos' => Yii::t('app', 'Ingresos'),
            'egresos' => Yii::t('app', 'Egresos'),
            'saldfinal' => Yii::t('app', 'Saldfinal'),
            'saldecuenta' => Yii::t('app', 'Saldecuenta'),
            'salddif' => Yii::t('app', 'Salddif'),
            'mes' => Yii::t('app', 'Mes'),
            'anio' => Yii::t('app', 'Anio'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCuenta()
    {
        return $this->hasOne(SigiCuentas::className(), ['id' => 'cuenta_id']);
    }

    /**
     * {@inheritdoc}
     * @return SigiEstadocuentasQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiEstadocuentasQuery(get_called_class());
    }
     public static function findResumen()
    {
       return   new  VwSigiResuestadocuentaQuery(
                VwSigiResuestadocuenta::className()
                );
    }
    public function beforeSave($insert) {
        if($insert){
            $this->estado=$this::ESTADO_CREADO;
            //$this->mes= str_pad($this->mes,2,'0',STR_PAD_LEFT);
           $this->codigo=$this->anio.$this->mes;
        }
        return parent::beforeSave($insert);
    }
    /*
     * Coloca un where para fiktrar las fechas del periodo*/
     
    public function whereFechas($campo){
        $limits=timeHelper::bordersDay($this->mes, $this->anio);
        return ['between',$campo,$limits[0],$limits[1]];
    }
    
    public function hasMovimientos(){
      /*echo $this->cuenta->getSigiMovBancos()
             ->andWhere($this->whereFechas('fopera'))
            ->createCommand()->rawSql;  */
       return $this->cuenta->getSigiMovBancos()
             ->andWhere($this->whereFechas('fopera'))->exists();
    }
    
    public function refreshMontos(){
        $cuenta=$this->cuenta;
        $this->saldmesant=$cuenta->ultimoSaldoMes($this->mes,$this->anio);
        $this->saldecuenta=$cuenta->saldo;
        $this->ingresos=$this->totalIngresos();
        $this->egresos=$this->totalEgresos();
        if($this->save()){
            return ['success',yii::t('base.errors','Se actualizaron las cifras')];
        }else{
            return ['error',yii::t('base.errors',$model->getFirstError())];
        }
    }
    
    public function totalIngresos(){
        $this->findResumen()->select('sum(monto)')->
               andWhere($this->whereFechas('fopera'))->
               andWhere(['ingreso'=>'1'])
             ->scalar();
    }
    
    public function totalEgresos(){
        $this->findResumen()->select('sum(monto)')->
               andWhere($this->whereFechas('fopera'))->
               andWhere(['ingreso'=>'0'])
             ->scalar();
    }
}
