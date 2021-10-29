<?php
use yii\helpers\Html;
use yii\bootstrap\Carousel;
?>




<title>:: DIAR - Operación y Gestión Inmobiliaria ::</title>



<form id="frmTemplate" name="frmTemplate" method="post" action="">

<table border="0" cellpadding="0" cellspacing="0" width="1024" align="center">

  <tr>

   <td style="background-color:#FFFFFF;width:1024px !important;" >

   	<!-- HEAD -->				

	<table id="mnuhead">
  <tr>
   <td style="background-color:#FFFFFF;">
	<div style="position:relative;"><a href="index.php"><div id="bnpslogo"><?=Html::img("@web/img/plataforma/bnpslogo.jpg",['width'=>152, 'heigh'=>156 ,'border'=>0]) ?></div></a></div>
    	 <div style="float:left;width:350px;height:80px;margin-left:161px;text-align:left;margin-top:32px;position:absolute;font-family:'Trebuchet MS';color:#BDB4B4;font-weight:700;font-size:13px;"><div style="color:#666666;">OPERACI&Oacute;N Y GESTI&Oacute;N INMOBILIARIA DIAR SAC</div>
         RUC  20535530875 </br>ADMINISTRACI&Oacute;N Y GESTI&Oacute;N DE PROPIEDADES
         </div>
	<div id="contecabez">	
    		
        <div id="div_opcmnuhead">
                <div id="div_intra">
<a href="javascript:;" id="logueo" ><div style="color:#FF9900;z-index:30;">Ingresa a tu inmueble</div></a>
               <div style="float:right;z-index:40;position:absolute;margin-top:-20px;margin-left:134px;">&nbsp; / &nbsp;<a href="bnpsmapsite.php">Mapa de Sitio</a></div>
               </div>
                <div style="float:right;margin-top:8px;padding-right:20px;">
                    <a href="https://es-la.facebook.com/"><?=Html::img("@web/img/plataforma/bnpicoface.jpg",['width'=>24, 'heigh'=>22 ,'border'=>0]) ?></a>
                <a href="https://twitter.com/"><?=Html::img("@web/img/plataforma/bnpicotwit.jpg",['width'=>24, 'heigh'=>22 ,'border'=>0]) ?></a>
                </div>
                
                <div id="div_bnpbuscar">
                  <input name="bBuscar" type="text" id="bBuscar" size="20" maxlength="25"  value="buscar..." onblur="if(this.value=='') this.value='buscar...';" onfocus="if(this.value=='buscar...') this.value='';" onkeyup="if(getKey(event)){ document.frmTemplate.action='bnpsbuscador.php'; document.frmTemplate.submit(); }" />
                </div> 
        </div>
	<div id="div_login" align="left"> 
	
<iframe height="280" width="220" scrolling="no" src="" frameborder="0"></iframe>

	</div>
    
	</div>
	</div>
      </td>
</tr>					
    <tr><td style="background-color:#FFFFFF;" ><div id="div_headmnu">
          <div align="left" id="div_fndmnu"><ul id='nav' class='dropdown'><li id='otros'><a href='index.php?opc=998' class='seleccionado'>INICIO</a></li><li><a href='bnpscontenido.php?id_cont=1&opc=1'  >NOSOTROS</a></li><li><a href='bnpscontenido.php?id_cont=4&opc=3'  >CLIENTES</a><ul ><li><a href='bnpsservicios.php?opc=2' target="_parent" >SERVICIOS</a></li></ul></li><li id='otros2'><a href='bnpscontactenos.php?opc=999'  >CONT&Aacute;CTENOS</a>
			</li></ul></div>        
    </td></tr>

</table>
	<!-- FIN HEAD -->	

   </td>

  </tr>	

	<!--ANIMACION -->

  <tr>

   <td  valign="top" style="background-color:#FFFFFF;width:1024px !important;">

		<div id="cont_anima"><div id='anicentral'>
                    <?php  
                    echo Carousel::widget([
                    'items' => [
                                [
                                    'content'=>Html::img("@web/img/plataforma/bnpsite02.jpg",['width'=>1026, 'heigh'=>364 ,'border'=>0]),
                              
                                ],
                                [
                                    'content'=>Html::img("@web/img/plataforma/bnpsite03.jpg",['width'=>1026, 'heigh'=>364 ,'border'=>0]),
                                  
                                ],
                                [
                                    'content'=>Html::img("@web/img/plataforma/bnpsite04.jpg",['width'=>1026, 'heigh'=>364 ,'border'=>0]),
                               
                                ],
                        ],
                           'options'=>['wrap'=>true,'interval'=>500],
                                ]
                        );
                    
                    ?></div>
			
        </div>

	</td>

  </tr>

<!--  <tr >

   <td  height="290" valign="top" style="background-color:#E3E3E3;width:1024px  !important;" >

    <div id="div_central"></div>

   </td>

  </tr>-->

  <tr>

 <td  height="290" valign="top" style="background-color:#E3E3E3;width:1024px  !important;" >

 

    <div style="width:480px;height:250px;float:right;margin-right:20px;margin-top:20px;" ><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr ><td height='250' valign='top'><table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="fs1" style="text-align: justify;" valign="top" width="405">
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="fs1" style="text-align: justify;" valign="top" width="405">
<div style="width: 230px; height: 78px; color: #496969; font-family: Trebuchet MS; font-size: 14px; font-weight: 300; margin-top: 15px; margin-left: 57px; position: absolute; z-index: 120;"><span style="color: #000000;">Al tener un sistema eficiente en la administraci&oacute;n se logra aprovechar al m&aacute;ximo tanto los recursos humanos como materiales y con ello&nbsp;habr&aacute; una rebaja sustancial en los gastos comunes, lo que da como resultado eficiencia y productividad. Nuestro plan de Administraci&oacute;n es innovador y mejora significativamente la gesti&oacute;n administrativa de su centro empresarial.</span></div>
<div style="z-index: 100; position: absolute;"><?=Html::img("@web/img/plataforma/bnpmantenimientoo.jpg",['width'=>485, 'heigh'=>250 ,'border'=>0])?></div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></td></tr></table></div>

    <div  style="width:480px; height:250px; float:left;margin-left:20px;margin-top:20px;"><table width='100%' border='0' cellspacing='0' cellpadding='0'><tr ><td height='250' valign='top'><table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="fs1" style="text-align: justify;" valign="top" width="405">
<table style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="fs1" style="text-align: justify;" valign="top" width="405">
<div style="width: 230px; height: 78px; color: #496969; font-family: Trebuchet MS; font-size: 14px; font-weight: 300; margin-top: 20px; margin-left: 63px; position: absolute; z-index: 120;"><span style="color: #000000;">Contamos con un equipo experimentado en el &aacute;rea de administraci&oacute;n, somos especialistas en el mantenimiento seg&uacute;n lo requieran las circunstancias; nuestro objetivo esta enfocado en responder y dar soluci&oacute;n de manera inmediata todos los requerimientos.</span></div>
<div style="z-index: 100; position: absolute;"><?=Html::img("@web/img/plataforma/bnpadministracionn.jpg",['width'=>485, 'heigh'=>250 ,'border'=>0])?></div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table></td></tr></table></div>

   </td>

  </tr>

  <tr>

      <td width="1024" height="350" valign="top" align="center" style="background-color:#FFFFFF;">

  	  <div id="div_conteinf" >

         <table style="width: 511px;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td align="center" valign="top" width="405">
<div style="text-align: justify; z-index: 20; position: absolute; margin-top: 102px;">
<div style="color: #4d6161; position: absolute; z-index: 50; margin:15px;">
<div style="text-align: center; padding-top: 30px;">
<p><strong><span style="font-family: trebuchet ms, geneva; font-size: medium;">DIAR OPERACI&Oacute;N Y GESTI&Oacute;N IMMOBILIARIA</span></strong></p>
</div>
<div style="text-align: center;">
<p><span style="font-size: small; font-family: trebuchet ms, geneva;">Es una empresa que tiene como prop&oacute;sito aliviar los problemas de administraci&oacute;n en <strong>Centros Empresariales y Comerciales. </strong>Nuestros&nbsp;clientes son importantes empresas Nacionales y Extranjeras,&nbsp;siempre quedaron satisfechos de nuestros trabajos, y de la puntualidad y seriedad con que tomamos cada misi&oacute;n recomendada, ellos son nuestra mejor carta de presentaci&oacute;n.</span></p>
</div>
</div>
<?=Html::img("@web/img/plataforma/bnpfondo_info.png",['width'=>770, 'heigh'=>196 ,'border'=>0])?></div>
<div style="z-index: 30; position: relative; left: 110px;"><?=Html::img("@web/img/plataforma/bnplogo_chico.png",['width'=>135, 'heigh'=>141 ,'border'=>0])?></div>
</td>
</tr>
</tbody>
</table>
      </div>

      </td>

  </tr>

  <tr>

   <td width="1024" ><div id="div_pie">
    <div id="cont_pie">
    
	     <div style="float:left;padding-top:15px;padding-left:10px;font-size:10px;width:120px;">Copyright &copy; DIAR 2013.</div>
         <div style="margin:auto;width:620px;padding-top:4px;">
	          <p>&nbsp;</p>
<p>&nbsp;</p>
<p>Calle Bolivar 298 Of. 401 - Miraflores Telf.:715 0960 /715 6417 /715 0961 /715 1485&nbsp;</p>		 </div>
		<div id="divpie_soc">Powered by <a href="http://www.bitnetperu.com" title="BITNETPERU S.A.C" target="_blank">BITNETPERU</a>
		</div>
        
	</div>
</div></td>

  </tr>

</table>

<div id="resultado" class="resultado"></div>

</form>

    <?php 
  $string=' 
function preCarga() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=preCarga.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}





$(function() {

	$(".newsticker-jcarousellite").jCarouselLite({

		vertical: true,

		hoverPause:true,

		visible: 4,

		auto:2500,

		speed:1500

	});



});

$(document).ready(function(){

	ejecutar();

	

 jQuery("#mycarousel").jcarousel({

		auto:3,

		wrap:"last",

		visible: 3,

		scroll:1,

		animation:1000

    });

	

				$("#anicentral").innerfade({
						speed: "slow",
						timeout: 5000,
						type: "random",
						containerheight: "364px"
					});
           
                        $("#ciclo").cycle({
            fx: "turnDown",
            delay: 1000,
            timeout: 4000            });
          
        
});' ;
  
  $this->registerJs($string, \yii\web\View::POS_HEAD);
?>  
    
    


