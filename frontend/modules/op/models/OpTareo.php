<?php

namespace frontend\modules\op\models;
use common\models\masters\Direcciones;
use Yii;

/**
 * This is the model class for table "{{%op_tareo}}".
 *
 * @property int $id
 * @property string $fecha
 * @property string $hinicio
 * @property string $hfin
 * @property string $descripcion
 * @property int $direcc_id
 * @property int $proc_id
 * @property int $os_id
 * @property int $detos_id
 * @property string $detalle
 *
 * @property OpLibro[] $opLibros
 * @property OpOsdet $detos
 * @property Direcciones $direcc
 * @property OpProcesos $proc
 * @property OpOs $os
 * @property OpTareodet[] $opTareodets
 */
class OpTareo extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%op_tareo}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['direcc_id', /*'proc_id', 'os_id', 'detos_id'*/], 'required'],
            [['direcc_id', 'proc_id', 'os_id', 'detos_id'], 'integer'],
            [['detalle'], 'string'],
            [['fecha'], 'string', 'max' => 10],
            [['hinicio', 'hfin'], 'string', 'max' => 5],
            [['descripcion'], 'string', 'max' => 40],
            [['detos_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOsdet::className(), 'targetAttribute' => ['detos_id' => 'id']],
            [['direcc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Direcciones::className(), 'targetAttribute' => ['direcc_id' => 'id']],
            [['proc_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpProcesos::className(), 'targetAttribute' => ['proc_id' => 'id']],
            [['os_id'], 'exist', 'skipOnError' => true, 'targetClass' => OpOs::className(), 'targetAttribute' => ['os_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'hinicio' => Yii::t('app', 'Hinicio'),
            'hfin' => Yii::t('app', 'Hfin'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'direcc_id' => Yii::t('app', 'Direcc ID'),
            'proc_id' => Yii::t('app', 'Proc ID'),
            'os_id' => Yii::t('app', 'Os ID'),
            'detos_id' => Yii::t('app', 'Detos ID'),
            'detalle' => Yii::t('app', 'Detalle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpLibros()
    {
        return $this->hasMany(OpLibro::className(), ['tareo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDetos()
    {
        return $this->hasOne(OpOsdet::className(), ['id' => 'detos_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirecc()
    {
        return $this->hasOne(Direcciones::className(), ['id' => 'direcc_id']);
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
    public function getOs()
    {
        return $this->hasOne(OpOs::className(), ['id' => 'os_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*public function getOpTareodets()
    {
        return $this->hasMany(OpTareodet::className(), ['tareo_id' => 'id']);
    }
*/
    /**
     * {@inheritdoc}
     * @return OpTareoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OpTareoQuery(get_called_class());
    }
    
    
    
    public function creaHijo(){
        $model=OpLibro::instance(); 
        $model->setAttributes([
            'tareo_id'=>$this->id,
            'hinicio'=>$this->hinicio,
            'proc_id'=>$this->proc_id,
            'os_id'=>$this->os_id,
            'detos_id'=>$this->detos_id,
            'descripcion'=>'Inicio de actividades',
            
        ]);
        //print_r($model->attributes); die();
            return $model->save();
    }
    
    public function afterSave($insert, $changedAttributes) {
        $this->refresh();
       // print_r($this->attributes); die();
        if($insert)
        //$this->creaHijo();
        return parent::afterSave($insert, $changedAttributes);
    }
}
