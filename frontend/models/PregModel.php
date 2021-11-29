<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PregModel extends Model
{
    public $preg1;
    public $preg2;
   

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            
        ];
    }

   
    /**
     * {@inheritdoc}
     */
  
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail()
    {
        return Yii::$app->mailer->compose()
            ->setTo('hipogea@hotmail.com')
            ->setFrom(['hipogea@hotmail.com' => 'JULIAN RAMIREZ'])
            ->setSubject('Leyeron el mensaje')
            ->setTextBody('leyeron el mensaje')
            ->send();
    }
}
