<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

?>
<?php
 //$this->registerCssFile("@web/css/residentes/carousel.css");
       
$this->registerjsFile("@web/js/residentes/jquery.inf.js",['position'=>View::POS_END]);
$this->registerjsFile("@web/js/residentes/jquery.innerfade.js",['position'=>View::POS_END]);
$this->registerjsFile("@web/js/residentes/jquery.carousel.min.js",['position'=>View::POS_END]);
$this->registerjsFile("@web/js/residentes/jquery.lightSlider.js",['position'=>View::POS_END]);
?>
<?PHP
        $this->render('header');
?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">

      <div class="item active">
        <img src="/frontend/web/img/plataforma/bnpsite02.jpg" alt="Los Angeles" style="width:100%;">
        <div class="carousel-caption">
          <!--<h3>Los Angeles</h3>
          <p>LA is always so much fun!</p>-->
        </div>
      </div>

      <div class="item">
        <img src="/frontend/web/img/plataforma/bnpsite03.jpg" alt="Chicago" style="width:100%;">
        <div class="carousel-caption">
           <!--<h3>Chicago</h3>
          <p>Thank you, Chicago!</p>-->
        </div>
      </div>
    
      <div class="item">
        <img src="/frontend/web/img/plataforma/bnpsite04.jpg" alt="New York" style="width:100%;">
        <div class="carousel-caption">
          <!-- <h3>New York</h3>
          <p>We love the Big Apple!</p>-->
        </div>
      </div>
  
    </div>

 </div>





 <script>
$('.carousel').carousel()
</script>
