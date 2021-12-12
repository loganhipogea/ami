<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;
use frontend\modules\sigi\models\SigiUserEdificios;
use yii\web\View;
use yii\widgets\ActiveForm;

    if (class_exists('frontend\modules\sigi\assets\AppAssetResidentes')) {
        //var_dump($this);die();
        frontend\modules\sigi\assets\AppAssetResidentes::register($this);
       // echo "salio";
       //die();
    } else {
        //app\assets\AppAsset::register($this);
    }

  $edificio= SigiUserEdificios::findOne(['user_id'=>h::userId()])->edificio;

      ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width"/>
        
        <meta name="keywords" content="administracion,meotegnia consultores,julian ramirez tenorio, inmuebles, administracion de inmuebles, diar, operacion, gestion, inmobiliaria, centro comercial, condominio, playa, empresarial, comercial, club" />



        <?= Html::csrfMetaTags() ?>
        
        <?php $this->registerCssFile("@web/css/residentes/blanco/buttons.css"); ?>
         <?php $this->registerCssFile("@web/css/residentes/blanco/bnpsite.css"); ?>
         <?php $this->registerCssFile("@web/css/residentes/blanco/default.ultimate.css"); ?>
         <?php $this->registerCssFile("@web/css/residentes/blanco/dropdown.css"); ?>
         <?php $this->registerCssFile("@web/css/residentes/blanco/jcstyle.css"); ?>
             <?php //$this->registerjsFile("@web/js/residentes/jquery.js",['position'=>View::POS_END]); ?>
          <?php //$this->registerjsFile("@web/js/residentes/vendors/@popperjs/popper.min.js",['position'=>View::POS_END]); ?>
          <?php //$this->registerjsFile("@web/js/residentes/is/is.min.js",['position'=>View::POS_END]); ?>
         <?php //$this->registerjsFile("@web/js/residentes/vendors/bootstrap/bootstrap.min.js",['position'=>View::POS_END]); ?>
         <?php //$this->registerjsFile("@web/js/residentes/vendors/is/is.min.js",['position'=>View::POS_END]); ?>
          <?php //$this->registerjsFile("@web/js/residentes/theme.js",['position'=>View::POS_END]); ?>

        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
   <body bgcolor="#ffffff"  style="height:auto;overflow: auto" class="wrapper">
       
    <?php $this->beginBody() ?>
  
       <div style="text-align: left;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style=""  class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
             <img src="/frontend/web/img/residentes/bnpslogo.jpg">
            </div>
            <div style=""  class="col-lg-8 col-md-8 col-sm-8 col-xs-12 nombreedificio"> 
                  <?PHP echo $edificio->nombre;   ?>
            </div>
               
      </div>
      
        <div  style="clear:right;height:auto;" class=" rayagris col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="text-align: left; clear:right;" class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
                <i style="font-size:2em"><span class="fa fa-user"></span></i>
                JULIAN RAMIREZ TENORIO/JESSENIA ESPINOZA RIVERA
            </div>
            <div style="clear:right; text-align: center" class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
              <?= Html::a('Salir', ['create'], ['class' => 'btn btn-danger']) ?>
               <?= Html::a('Cambiar clave', ['create'], ['class' => 'btn btn-warning']) ?>
            </div>
           
       </div>
       
   
       
       
       
       
       
       <div class="contenido">
       <?php  
       echo $content;       
       ?>
       </div>
       <div id="piefooter" style="background-color: black; bottom:0px;position: fixed;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
             <div style="" class="col-lg-2 col-md-3 col-sm-6 col-xs-6"> 
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                   <?=Html::a('<span class="fa fa-money iconopie"></span>',Url::to(['/sigi/default/resi-factu'])) ?>
                    
                 </div>
                 <div  class=" letrapie col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                   <?=Html::a('Estado de cuenta',Url::to(['/sigi/default/resi-factu'])) ?>
                    
                 </div>
            </div>
             <div style="" class="col-lg-2 col-md-3 col-sm-6 col-xs-6"> 
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <?=Html::a('<span class="fa fa-tint iconopie"></span>',Url::to(['/sigi/default/resi-agua'])) ?>
                   
                 </div>
                 <div  class=" letrapie col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                     <?=Html::a('Agua potable',Url::to(['/sigi/default/resi-agua'])) ?>
                   
                 </div>
            </div>
           <div style="" class="col-lg-2 col-md-3 col-sm-6 col-xs-6"> 
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <span class="fa fa-envelope iconopie"></span>
                 </div>
                 <div  class=" letrapie col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                     
                     <?=Html::a('Mensajes',Url::to(['/message/message/inbox'])) ?>
                 </div>
            </div>
           <div style="" class="col-lg-2 col-md-3 col-sm-6 col-xs-6"> 
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <span class="fa fa-phone iconopie"></span>
                 </div>
                 <div  class=" letrapie col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    Emergencias
                 </div>
            </div>
           <div style="" class="col-lg-2 col-md-3 col-sm-6 col-xs-6"> 
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <span class="fa fa-eye iconopie"></span>
                 </div>
                 <div  class=" letrapie col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    FACTURACION
                 </div>
            </div>
           <div style="" class="col-lg-2 col-md-3 col-sm-6 col-xs-6"> 
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    <span class="fa fa-eye iconopie"></span>
                 </div>
                 <div  class=" letrapie col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                    FACTURACION
                 </div>
            </div>
            
           
       </div>
       
       
    <?php $this->endBody() ?>
  </body>
    </html>
    <?php $this->endPage() ?>



