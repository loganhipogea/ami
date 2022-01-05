<?php

namespace frontend\modules\sigi\models;

use Yii;
use common\models\masters\Clipro;
/**
 * This is the model class for table "{{%sigi_apoderados}}".
 *
 * @property int $id
 * @property int $edificio_id
 * @property string $codpro
 * @property string $facturaigv
 * @property string $permite1
 * @property string $permite2
 * @property string $detalles
 * @property string $permiteventa
 * @property string $permitealquiler
 *
 * @property Clipro $codpro0
 */
class SigiApoderados extends \common\models\base\modelBase
{
    /**
     * {@inheritdoc}
     */
   public $booleanFields=['cobranzaindividual','facturindividual','tienejunta','emisordefault','facturaigv','permiteventa' ];
    public static function tableName()
    {
        return '{{%sigi_apoderados}}';
    }

     
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edificio_id', 'codpro'], 'required'],
            [['edificio_id'], 'integer'],
            [['detalles'], 'string'],
             [['tienejunta','emisordefault','facturaigv','permiteventa','cobranzaindividual','facturindividual'], 'safe'],
            [['codpro'], 'string', 'max' => 6],
            //[['facturaigv', 'permite1', 'permite2', 'permiteventa', 'permitealquiler'], 'string', 'max' => 1],
            [['codpro'], 'exist', 'skipOnError' => true, 'targetClass' => Clipro::className(), 'targetAttribute' => ['codpro' => 'codpro']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('sigi.labels', 'ID'),
            'edificio_id' => Yii::t('sigi.labels', 'Edificio ID'),
            'codpro' => Yii::t('sigi.labels', 'Codpro'),
            'facturaigv' => Yii::t('sigi.labels', 'Facturaigv'),
             'facturindividual' => Yii::t('sigi.labels', 'Fact Individual'),
            'cobranzaindividual' => Yii::t('sigi.labels', 'Cobranza individual'),
            'permite1' => Yii::t('sigi.labels', 'Permite1'),
            'permite2' => Yii::t('sigi.labels', 'Permite2'),
            'detalles' => Yii::t('sigi.labels', 'Detalles'),
            'permiteventa' => Yii::t('sigi.labels', 'Permiteventa'),
            'permitealquiler' => Yii::t('sigi.labels', 'Permitealquiler'),
            'tienejunta' => Yii::t('sigi.labels', 'Junta Directiva'),
            'facturaigv' => Yii::t('sigi.labels', 'Deduce Igv'),
            'emisordefault' => Yii::t('sigi.labels', 'Emisor por defecto'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
    }
    
    public function getEdificio()
    {
        return $this->hasOne(Edificios::className(), ['id' => 'edificio_id']);
    }
    
    public function getUnidades(){
        return $this->hasOne(SigiUnidades::className(), ['edificio_id' => 'edificio_id','codpro'=>'codpro']);
    }

    /**
     * {@inheritdoc}
     * @return SigiApoderadosQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiApoderadosQuery(get_called_class());
    }
    
    public function hasDepasImputables(){
        return SigiUnidades::find()->where([
            'edificio_id'=>$this->edificio_id,
             'codpro'=>$this->codpro,
             'imputable'=>'1',
            ])->exists();
    }
    
    
    public function nUnidadesImputablesPadres(){
       return  $this->getUnidades()->andWhere(['parent_id'=>null,'imputable'=>'1'])->count();
    }
    
    public function nUnidadesImputablesHijas(){
       return  $this->getUnidades()->
               andWhere(['>','parent_id',0])->
               andWhere(['imputable'=>'1'])->count();
    }
    
    public function areaUnidadesImputablesPadres(){
        return  $this->getUnidades()->select(['suma(area)'])->
               andWhere(['parent_id'=>null,'imputable'=>'1'])->scalar();
    }
    public function areaUnidadesImputablesHijas(){
       return  $this->getUnidades()->select(['sum(area)'])->
               andWhere(['>','parent_id',0])->
               andWhere(['imputable'=>'1'])->scalar();
    }
    public function resumenUnidadesImputablesPadresPorTipo(){
       return $this->getUnidades()->select(['count(*) as cantidad','b.desunidad','sum(t.area) as area','b.codtipo'])->
       innerJoin('{{%sigi_tipounidad}} b','t.codtipo=b.codtipo')
               ->andWhere(['parent_id'=>null,'imputable'=>'1'])->
               groupBy(['b.desunidad','b.codtipo'])->asArray()->all();
       //var_dump($t[0]);die();
    }
    
}
