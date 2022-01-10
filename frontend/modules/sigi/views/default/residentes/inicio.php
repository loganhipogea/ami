<?php
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

?>
<?php
 $this->registerCssFile("@web/css/plataforma/lightSlider.css");
 
  $this->registerjsFile("@web/js/plataforma/jquery.lightSlider.js",[
      'depends'=> 'yii\web\JqueryAsset',
      'position'=>View::POS_HEAD]);     
 //$this->registerjsFile("@web/js/residentes/jquery_carrusel.js",['position'=>View::POS_HEAD]);      
 //$this->registerjsFile("@web/js/residentes/slick.js",['position'=>View::POS_HEAD]);      

//$this->registerjsFile("@web/js/residentes/jquery.inf.js",['position'=>View::POS_HEAD]);
//$this->registerjsFile("@web/js/residentes/jquery.innerfade.js",['position'=>View::POS_HEAD]);
//$this->registerjsFile("@web/js/residentes/jquery.jcarousel.min.js",['position'=>View::POS_HEAD]);
//$this->registerjsFile("@web/js/residentes/jquery.lightSlider.js",['position'=>View::POS_HEAD]);
?>
<?PHP
        echo $this->render('header',['useredificio'=>$useredificio]);
        $edificio=$useredificio->edificio;
        $imagenes=$edificio->imagenes();
        //print_r($edificio->imagenes());die();
?>
<table>   
    <tr>
        <td>
	<div id="gamesHolder">
		<div id="games">
                    <?php foreach($imagenes as $ruta){  ?>
                    <a href="#">
                    <img src="<?=$ruta?>" width="1026" height="364"  /> 
                    </a>
                     <?php }  ?>
                </div>
        </DIV>
        </td>
  </tr>
</table> 			
 <script>
$(document).ready(function() {
	$('#games').coinslider({ hoverPause: false });
});
</script>

