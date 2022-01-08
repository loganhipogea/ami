<?php

namespace frontend\modules\sigi\models;

use Yii;
use common\behaviors\FileBehavior;
//USE nemmo\attachments\behaviors\FileBehavior;
use common\helpers\h;
/**
 * This is the model class for table "{{%sigi_vouchers}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string $fecha
 */
class SigiVouchers extends \common\models\base\modelBase
{
   public function triggerUpload(){
        //yii::error('REGISTRANO EK EVENTO '.$this->id);
        /** @var $files \nemmo\attachments\models\File[] */
           $sesion=h::session();
                 $nombresesion='recibo'.h::userId();
                 $valores=$sesion->get($nombresesion);
           
                 /* yii::error('VALORES DE SESION');
                  yii::error($valores);*/
                 /*Buscamos primero aquellos Ids Vouichesr
                  * que estan comprometidos anteriormentes con
                  * estos id kardex dela sesion
                  */
                 $idsVouchersAntiguos=SigiKardexdepa::find()->select(['voucher_id'])->
                         andWhere(['id'=>$valores])->column();
                 /*yii::error('ids vouchers antiguis ');
                  yii::error($idsVouchersAntiguos);*/
                 $vouchersAnt=self::find()->andWhere(['id'=>$idsVouchersAntiguos])->all();
                 /* yii::error('Recorriendo los voucchres antiguos '); 
                   yii::error($vouchersAnt); */
                 foreach($vouchersAnt as $voucher){
                      //yii::error('Voucher antiguo id es  '.$voucher->id); 
                      if($voucher->id <> $this->id){//Por si acaso nos aseguramos , aunque parece imposible
                       // yii::error('Borrando el Voucher antiguo id   '.$voucher->id); 
                          $voucher->delete();
                       
                      }
                 }
                 /* yii::error('Actualizando el kardex');
                  yii::error($idsVouchersAntiguos);*/
                 SigiKardexdepa::updateAll(['voucher_id'=>$this->id],['id'=>$valores]);
                 $sesion->set($nombresesion,[]);
            
   } 
    
    
    public function behaviors() {
        return [           
            'fileBehavior' => [
                'class' => FileBehavior::className()
                      ],            
        ];
    }

    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%sigi_vouchers}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['fecha'], 'string', 'max' => 19],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'fecha' => Yii::t('app', 'Fecha'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return SigiVouchersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SigiVouchersQuery(get_called_class());
    }
    
    public function beforeDelete() {
        $this->deleteAllAttachments();
        return parent::beforeDelete();
    }
    
}
