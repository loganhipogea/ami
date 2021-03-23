<?php
namespace frontend\modules\sigi\behaviors;
use common\behaviors\FileBehavior as FiBe;
use frontend\modules\sigi\models\SigiMovimientosPre;
use yii;
class FileBehavior_residente extends Fibe
{
    public function  saveUploads($event){
        parent::saveUploads($event);
        //var_dump($this->mail());die();
        //$this->mail();
        //yii::error('estableciendo ');
       /* $valor=SigiMovimientosPre::createBasic([ 
            'kardex_id'=>$this->owner->id,
            'edificio_id'=>$this->owner->edificio_id,
            'cuenta_id'=>$this->owner->edificio->cuentas[0]->id,
            'tipomov'=> \frontend\modules\sigi\models\SigiTipomov::TIPOMOV_DEFAULT,
            'glosa'=>yii::t('sigi.labels','PAGO DE CUOTA').'-'.$this->owner->unidad->numero, 
            'monto'=>$this->owner->facturacion->montoFacturado(), 
            'activo'=>'1'            
        ]);*/
        
        
       // \yii::error('Si salió mal');
        return true; 
    }
    
  public function mail(){
      $mail=\common\helpers\h::user()->identity->email;
        $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificacion de Pago')
            ->setFrom([$mail=>$this->owner->unidad->nombre])
            ->setTo(\common\helpers\h::gsetting('sigi', 'correoCobranza1'))
            ->SetHtmlBody("Buenas Tardes <br>"
                    . "La presente es para notificarle que He adjuntado mi voucher de pago
                        <br>
                    ")->attach($this->owner->files[0]->path);
           
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo con el voucher';
    } catch (\Swift_TransportException $Ste) {      
         $mensajes['error']=$Ste->getMessage();
    }
    return $mensajes;
    
  } 
}


