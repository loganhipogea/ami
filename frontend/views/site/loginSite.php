<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

 // echo $model::className();
    
$this->title = yii::t('base.labels','Ingreso');

$fieldOptions1 = [
    'options' => ['class' => 'input is-medium input-login is-size-6'],
   // 'inputTemplate' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'input is-medium input-login is-size-6'],
    //'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>


        
        <?php //echo Yii::$app->geoip->ip()->isoCode; */  ?> 
    
    <!-- /.login-logo -->
  <div class="hero is-fullheight bg-login">
        <div class="hero-body">
          <div class="container has-text-centered">
            <div class="column is-offset-1 is-4-widescreen is-5-desktop  is-6-tablet is-offset-0-mobile is-12-mobile">
                <div class="box py-6 px-6">
                    <div class="logo pb-4 pt-2">
                        <?=Html::img('@web/img/logo.png',['width'=>"80%"])?>
                     </div>  
       <?php //Html::img('@web/img/media_providers.png',['height'=>100,'width'=>100])?>
                
        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
        <div class="field">
          <div class="control">
        <?= $form
            ->field($model, 'username', [])
            ->label(false)
            ->textInput(['class'=>'input is-medium input-login is-size-6','placeholder' => 'Nombre usuario']) ?>
         <p class="help-block help-block-error"></p>
          </div>
         </div>
        <div class="field">
          <div class="control">
        <?= $form
            ->field($model, 'password', [])
            ->label(false)
            ->passwordInput(['class'=>'input is-medium input-login is-size-6','placeholder' => 'Contraseña']) ?>
          <p class="help-block help-block-error"></p>
          </div>
         </div>
        <div class="botones">
           
            
                <?= Html::submitButton(yii::t('base.labels','Autenticar'), ['class' => 'button is-block is-fullwidth is-normal btn-ingresa is-uppercase', 'name' => 'login-button']) ?>
           
            <hr class="m-3">
                <?= Html::a(yii::t('base.labels','Olvidé mi contraseña'),Url::to(['request-password-reset']) ,['class' => 'button is-block is-fullwidth is-normal btn-recupera is-uppercase']) ?>
            
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>
                    
            <!-- #dialog is the id of a DIV defined in the code below -->
          
            <div id="divcreditos">
                <ul>
                   
                </ul>
            </div>
        <?php //echo Html::a(yii::t('base.labels','Register'),Url::to(['/inter/default/base-auth']))?>
         <div class="logo p-5 pt-6 is-hidden-mobile"></div>
                </div>
            </div>
          </div>
        </div>
      </div>

  
<?PHP 
$this->registerJs(" $('#formButton').click(function(){
        $('#divcreditos').toggle('slow');
    }); ", \yii\web\View::POS_END);    
    ?>
    <!-- /.login-box-body -->