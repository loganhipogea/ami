<?php

namespace frontend\modules\mat\models;
use frontend\modules\mat\models\MatDetreq;
use common\models\masters\Maestrocompo;
use Yii;

/**
 * This is the model class for table "{{%mat_stock}}".
 *
 * @property int $id
 * @property string $codart
 * @property string $cant
 * @property string $um
 * @property string $ubicacion
 * @property string $cantres
 * @property string $codal
 * @property string $valor
 * @property string $lastmov
 *
 * @property Maestrocompo $codart0
 */
class MatStock extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_stock}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codart','um','cant'], 'required'],
            [['cant', 'cantres', 'valor'], 'number'],
            [['codart', 'ubicacion'], 'string', 'max' => 14],
             [['um'], 'valida_um_base'],
             [['valor_unit'], 'safe'],
            [['um', 'codal'], 'string', 'max' => 4],
            [['lastmov'], 'string', 'max' => 10],
            [['codart'], 'unique'],
            [['codart'], 'exist', 'skipOnError' => true, 'targetClass' => Maestrocompo::className(), 'targetAttribute' => ['codart' => 'codart']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'codart' => Yii::t('app', 'Codart'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'ubicacion' => Yii::t('app', 'Ubicacion'),
            'cantres' => Yii::t('app', 'Cantres'),
            'codal' => Yii::t('app', 'Codal'),
            'valor' => Yii::t('app', 'Valor'),
            'lastmov' => Yii::t('app', 'Lastmov'),
        ];
    }
 
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Maestrocompo::className(), ['codart' => 'codart']);
    }

    public function geStock()
    {
        return $this->hasMany(MatStock::className(), ['codart' => 'codart']);
   }
     /*public function getKardex() {
        return $this->hasMany(MatKardex::className(), ['stock_id' => 'id']);
    }*/
    /**
     * {@inheritdoc}
     * @return MatStockQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatStockQuery(get_called_class());
    }
    
    
    /*No se puede registrar un stock con la unidad de medida
     * difrente a la unidad  base
     */
    
    public function valida_um_base(){
        if(!$this->material->codum ==$this->um)
        $this->addError('um',yii::t('base.errors','Esta unidad de medida no es la base'));
    }
    
    public function actualiza(){
        
    }
    
    
}
