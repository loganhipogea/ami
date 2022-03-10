<?php

namespace frontend\modules\mat\models;

use Yii;

/**
 * This is the model class for table "{{%mat_vw_req}}".
 *
 * @property string $codtra
 * @property string $numero
 * @property string $fechaprog
 * @property string $fechasol
 * @property string $descripcion
 * @property int $req_id
 * @property string $codart
 * @property string $descridetalle
 * @property string $cant
 * @property string $um
 * @property string $imptacion
 * @property string $tipim
 * @property string $item
 * @property string $ap
 * @property string $am
 * @property string $nombres
 */
class MatVwReq extends \common\models\base\modelBase
{
    
    public $fechasol1;
    public $fechaprog1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%mat_vw_req}}';
    }
 public $dateorTimeFields=[
     'fechaprog'=>self::_FDATE,'fechaprog1'=>self::_FDATE,
     'fechasol'=>self::_FDATE,'fechasol1'=>self::_FDATE,
         
         ];
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero', 'ap', 'am', 'nombres'], 'required'],
            [['req_id'], 'integer'],
            [['cant','id'], 'number'],
            [['codtra'], 'string', 'max' => 6],
            [['numero', 'fechaprog', 'fechasol'], 'string', 'max' => 10],
            [['descripcion', 'descridetalle', 'ap', 'am', 'nombres'], 'string', 'max' => 40],
            [['codart', 'imptacion'], 'string', 'max' => 14],
            [['um', 'item'], 'string', 'max' => 4],
            [['tipim'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'codtra' => Yii::t('app', 'Codtra'),
            'numero' => Yii::t('app', 'Numero'),
            'fechaprog' => Yii::t('app', 'F. prog'),
            'fechasol' => Yii::t('app', 'Fecha'),
            'fechaprog1' => Yii::t('app', 'F. prog'),
            'fechasol1' => Yii::t('app', 'Fecha'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'req_id' => Yii::t('app', 'Req ID'),
            'codart' => Yii::t('app', 'Codart'),
            'descridetalle' => Yii::t('app', 'Descripción'),
            'cant' => Yii::t('app', 'Cant'),
            'um' => Yii::t('app', 'Um'),
            'imptacion' => Yii::t('app', 'Imputacion'),
            'tipim' => Yii::t('app', 'Tipim'),
            'item' => Yii::t('app', 'Item'),
            'ap' => Yii::t('app', 'Ap'),
            'am' => Yii::t('app', 'Am'),
            'nombres' => Yii::t('app', 'Nombres'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MatVwReqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MatVwReqQuery(get_called_class());
    }
}
