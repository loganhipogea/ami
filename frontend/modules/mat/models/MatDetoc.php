<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_detoc}}".
 *
 * @property int $id
 * @property int $oc_id
 * @property int $detreq_id
 * @property string $item
 * @property string $cant
 * @property string $um
 * @property string $codart
 * @property string $descripcion
 * @property string $detalle
 * @property string $punit
 * @property string $punitimpuesto
 * @property string $ptotal
 * @property string $ptotalimpuesto
 *
 * @property MatOc $oc
 * @property MatDetreq $detreq
 */
class MatDetoc extends \common\models\base\modelBase
{
    
    public $id_req=null;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_detoc}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oc_id', 'detreq_id'], 'integer'],
            [['cant', 'punit', 'punitimpuesto', 'ptotal', 'ptotalimpuesto'], 'required'],
            [['cant', 'punit', 'punitimpuesto', 'ptotal', 'ptotalimpuesto'], 'number'],
            [['detalle'], 'string'],
            [['item'], 'string', 'max' => 4],
            [['um'], 'string', 'max' => 3],
            [['codart'], 'string', 'max' => 14],
            [['descripcion'], 'string', 'max' => 40],
            [['oc_id'], 'exist', 'skipOnError' => true, 'targetClass' => MatOc::className(), 'targetAttribute' => ['oc_id' => 'id']],
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
            'oc_id' => Yii::t('app', 'Oc ID'),
            'detreq_id' => Yii::t('app', 'Detreq ID'),
            'item' => Yii::t('app', 'Item'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'codart' => Yii::t('app', 'Codart'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'detalle' => Yii::t('app', 'Detalle'),
            'punit' => Yii::t('app', 'Punit'),
            'punitimpuesto' => Yii::t('app', 'Punitimpuesto'),
            'ptotal' => Yii::t('app', 'Ptotal'),
            'ptotalimpuesto' => Yii::t('app', 'Ptotalimpuesto'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOc()
    {
        return $this->hasOne(MatOc::className(), ['id' => 'oc_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetreq()
    {
        return $this->hasOne(MatDetreq::className(), ['id' => 'detreq_id']);
    }

    
    public function cargaImpuesto(){
        return 1.18;
    }
    /**
     * {@inheritdoc}
     * @return MatdetocQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatdetocQuery(get_called_class());
    }
    
    public function fillAttributesFromReq($id_detreq){        
        if(!is_null($model= MatDetreq::findOne($id_detreq))){
            $this->setAttributes([
                $this->cant=$model->cant,
                $this->um=$model->um,
                $this->codart=$model->codart,
                $this->descripcion=$model->descripcion,
            ]);
        }
    }
    
    public function beforeSave($insert) {
        if($insert){
           $this->item='1'.str_pad($this->oc->getItems()->count()+1,3,'0',STR_PAD_LEFT);
         
        }
        $this->punitimpuesto=$this->punit*$this->cargaImpuesto();
        $this->ptotal=$this->punit*$this->cant;
        $this->ptotalimpuesto=$this->ptotal*$this->cargaImpuesto();
        return parent::beforeSave($insert);
    }
}
