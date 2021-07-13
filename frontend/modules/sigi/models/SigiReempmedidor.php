<?php

namespace frontend\modules\sigi\models;

use Yii;

/**
 * This is the model class for table "{{%sigi_reempmedidor}}".
 *
 * @property int $id
 * @property int $suministro_id_ant
 * @property string $ultima_lectura
 * @property string $fecha_ultima_lectura
 * @property string $fecha_reemplazo
 * @property string $codsuministro_actual
 * @property string $lectura_actual
 * @property string $detalle
 *
 * @property SigiSuministros $suministroIdAnt
 */
class SigiReempmedidor extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    
     public $dateorTimeFields = [
        'fecha_ultima_lectura' => self::_FDATETIME,
        'fecha_reemplazo' => self::_FDATETIME,
        //'ftermino' => self::_FDATETIME
    ];
    public static function tableName()
    {
        return '{{%sigi_reempmedidor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['suministro_id_ant', 'ultima_lectura',
                //'fecha_ultima_lectura', 
                'fecha_reemplazo',
                'codsuministro_actual'], 'required'],
            [['suministro_id_ant','suministro_id_act'], 'integer'],
            [['suministro_id_act' ],'safe'],
            [['fecha_reemplazo' ],'validate_fechas'],
            [['ultima_lectura', 'lectura_actual'], 'number'],
            [['detalle'], 'string'],
            [['fecha_ultima_lectura', 'fecha_reemplazo'], 'string', 'max' => 10],
            [['codsuministro_actual'], 'string', 'max' => 12],
            [['suministro_id_ant'], 'exist', 'skipOnError' => true, 'targetClass' => SigiSuministros::className(), 'targetAttribute' => ['suministro_id_ant' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'suministro_id_ant' => Yii::t('app', 'Suministro Ant'),
            'ultima_lectura' => Yii::t('app', 'Ultima Lectura'),
            'fecha_ultima_lectura' => Yii::t('app', 'Fec Ult Lectura'),
            'fecha_reemplazo' => Yii::t('app', 'Fecha Reemplazo'),
            'codsuministro_actual' => Yii::t('app', 'Cod Nuevo Suministro'),
            'lectura_actual' => Yii::t('app', 'Lectura inicial de seteo'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuministroAnt()
    {
        return $this->hasOne(SigiSuministros::className(), ['id' => 'suministro_id_ant']);
    }

    /**
     * {@inheritdoc}
     * @return SigiReempmedidorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiReempmedidorQuery(get_called_class());
    }
    
    public function afterSave($insert, $changedAttributes) {
        
        //self::updateAll(['suministro_id_act'=> ])
      RETURN   parent::afterSave($insert, $changedAttributes);
    }
    
    public function resolveSuministro(){
        $model=New SigiSuministros();
        $modelAnt=$this->suministroAnt;
        $model->setAttributes($modelAnt->attributes);
        $model->codsuministro=$this->codsuministro_actual; 
        $model->liminf=(is_null($this->lectura_actual))?0:$this->lectura_actual;
        $grabo=$model->save();
        $model->refresh();
        $modelLectura=New SigiLecturas();
        $modelLectura->setAttributes([
            'suministro_id'=>$this->suministroAnt->id,
            'lectura'=>$this->ultima_lectura,
             'flectura'=>$this->fecha_ultima_lectura,
            'unidad_id'=>$modelAnt->unidad_id,
            'mes'=>date('j',strtotime($this->swichtDate('fecha_ultima_lectura',false))),
            'anio'=>date('Y',strtotime($this->swichtDate('fecha_ultima_lectura',false))),
             ]);
        //return $model;
    }
  
    
    
  public function validate_fechas($attribute,$params){
      $flectura=$this->sumnistroAnt->
                      lastRead()->flectura;
      if($this->toCarbon('fecha_reemplazo')->
              lt(
                      $this->sumnistroAnt->
                      lastRead()->toCarbon('flectura')
                 )) 
       $this->addError('fecha_reemplazo',yii::t('sigi.errors',
               'La fecha de reemplazo no puede ser anterior a la última fecha de lectura {flectura}',
               ['flectura'=>$flectura])
               );
  }
}
