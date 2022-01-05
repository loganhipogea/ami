<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

?>
<?php
 //$this->registerCssFile("@web/css/residentes/carousel.css");
       
//$this->registerjsFile("@web/js/residentes/jquery.inf.js",['position'=>View::POS_END]);
//$this->registerjsFile("@web/js/residentes/jquery.innerfade.js",['position'=>View::POS_END]);
//$this->registerjsFile("@web/js/residentes/jquery.jcarousel.min.js",['position'=>View::POS_END]);
//$this->registerjsFile("@web/js/residentes/jquery.lightSlider.js",['position'=>View::POS_END]);
?>
<?PHP
        echo $this->render('header',['useredificio'=>$useredificio]);
?>
<div id="gamesHolder">
		<div id="games">
<a href="#">
     <img src=" <?= yii\helpers\Url::to("@web/img/plataforma/bnpsite02.jpg")?> " width="1026" height="364"  />
        
   
</a>
<a href="#">
 <img src=" <?= yii\helpers\Url::to("@web/img/plataforma/bnpsite03.jpg")?> " width="1026" height="364"  />
     
</a>
<a href="#">
  <img src=" <?= yii\helpers\Url::to("@web/img/plataforma/bnpsite04.jpg")?> " width="1026" height="364"  />
     
</a>

                </div>
        </DIV>





 <script>
$(document).ready(function() {
	$('#games').coinslider({ hoverPause: false });
});
</script>

