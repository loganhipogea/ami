<?php
namespace frontend\modules\cc\models;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class MovimientoForm extends \common\models\base\modelBase
{
    public $tipo;
    public $cuenta_id;
    
 public static function tableName()
    {
        return '{{%cc_movimientos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['tipo', 'cuenta_id'], 'required'],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
   
public function attributeLabels()
    {
        return [
            'cuenta_id' => Yii::t('sigi.labels', 'Cuenta'),
            'tipo' => Yii::t('sigi.labels', 'Tipo'),
            
           
        ];
    }
    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    
}
