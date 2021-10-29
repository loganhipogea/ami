<?php
use yii\helpers\Html;
use yii\web\View;

    if (class_exists('frontend\assets\AppAsset')) {
        //var_dump($this);die();
        frontend\assets\AppAsset::register($this);
       // echo "salio";
       //die();
    } else {
        //app\assets\AppAsset::register($this);
    }

  

      ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="administracion,meotegnia consultores,julian ramirez tenorio, inmuebles, administracion de inmuebles, diar, operacion, gestion, inmobiliaria, centro comercial, condominio, playa, empresarial, comercial, club" />



        <?= Html::csrfMetaTags() ?>
        
        
         <?php $this->registerCssFile("@web/css/plataforma/bnpsite.css"); ?>
         <?php $this->registerCssFile("@web/css/plataforma/default.ultimate.css"); ?>
         <?php $this->registerCssFile("@web/css/plataforma/dropdown.css"); ?>
         <?php $this->registerCssFile("@web/css/plataforma/jcstyle.css"); ?>
        <?php $this->registerCssFile("@web/css/plataforma/jcstyle.css"); ?>

        
         <?php $this->registerjsFile("@web/js/plataforma/jquery.js",['position'=>View::POS_HEAD]); ?>
         <?php $this->registerjsFile("@web/js/plataforma/jquery.jcarousel.min.js",['position'=>View::POS_HEAD]); ?>
                <?php $this->registerjsFile("@web/js/plataforma/jcarousellite_1.0.1c4.js",['position'=>View::POS_HEAD]); ?>
            
         <?php $this->registerjsFile("@web/js/plataforma/bnpsajaxweb.js",['position'=>View::POS_HEAD]); ?>
       <?php $this->registerjsFile("@web/js/plataforma/bnpsgeneralw.js",['position'=>View::POS_HEAD]); ?>
       <?php $this->registerjsFile("@web/js/plataforma/jquery-cycle.js",['position'=>View::POS_HEAD]); ?>
        <?php $this->registerjsFile("@web/js/plataforma/jquery.innerfade.js",['position'=>View::POS_HEAD]); ?>
        
             <?php $this->registerjsFile("@web/js/plataforma/bnpsitelb.js",['position'=>View::POS_HEAD]); ?>
 <?php $this->registerjsFile("@web/js/plataforma/jquery.inf.js",['position'=>View::POS_HEAD]); ?>
       
         <?php $this->registerjsFile("@web/js/plataforma/jquery.dropdownPlain.js",['position'=>View::POS_HEAD]); ?>
       
      
        
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
   <body >
       
 <?php $this->beginBody() ?>
    
       

        <?= $content ?>

   

    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>



