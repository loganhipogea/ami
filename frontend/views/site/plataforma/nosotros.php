<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
?>

<?php echo $this->render('header'); ?>
	
  <!--CONTENIDO EN UNA FILA -->
   <tr>
       <td colspan="5" valign="top" align="left" height="600" style="background-color:#FFFFFF;" >
        <div style="height:50px"></div>
        <div  class="div_cont">
                  <div><table width='100%' align='center' border='0' cellspacing='0' cellspading='0'><tr><td class='lineahead' colspan='3' >&nbsp;&nbsp;<a href='index.php'>INICIO</a> - QUIENES SOMOS</td></tr><tr ><td style='width:420px;  padding-top:10px;' class='titcontenido' >&nbsp;</td><td style='float:right;width:370px;'> 
						<div style='float:right;width:auto;margin-right:12px;'>
						<!--
						<div id='div_twit' style='float:left;width:auto;'><div style ='float:left; z-index:2;'><a href='https://twitter.com/share' class='twitter-share-button'  data-lang='es'>Twittear		 						</a></div></div>												
						<div id='div_face' style='float:left;width:auto;'><div style ='padding-right:10px;float:left;z-index:-1;'>
						<div id='fb-root' ></div><div  class='fb-like'  data-href='' data-send='false' data-layout='button_count' data-width='120' data-show-faces='false'></div></div></div>
						-->
						<div id='div_print' style='float:left;'>
                                                <?=Html::img("@web/img/plataforma/imprimir.jpg",['style'=>'cursor:pointer','title'=>'Imprimir','onclick'=>'window.open("bnpsimpresion.php?id_cont=1","","status=no,width=650,height=570 ,top=50,left=10,scrollbars=yes,toolbar=no");']) ?>
						</div>
						
						<div id='div_send' style='float:left;padding-left:13px;padding-top:3px;'>
                                                <?=Html::img("@web/img/plataforma/enviar.jpg",['style'=>'cursor:pointer','title'=>'Enviar a un amigo','onclick'=>'']) ?>
						</div>
						
						</div>
						</td></tr><tr><td style='width:850px;position:absolute;  padding-left:30px;' class='titcontenido'>QUIENES SOMOS</td></tr></tr><tr ><td valign='top' colspan='3' class='classcontenido'><p>&nbsp;&nbsp;</p>
<table style="width: 970px; margin-right: auto; margin-left: auto;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="fs1" style="text-align: justify;" valign="top" width="405">
<p><strong>DIAR OPERACI&Oacute;N Y GESTI&Oacute;N INMOBILIARIA</strong> es una empresa que tiene como prop&oacute;sito aliviar los problemas de administraci&oacute;n en edificios, centros empresariales y comerciales. Para esto, contamos con personal que le garantiza un trabajo eficaz y una permanente preocupaci&oacute;n por sus necesidades, con una atenci&oacute;n personalizada y soluciones r&aacute;pidas y que se rige de acuerdo a las leyes, disposiciones y normas que regulan la Ley de R&eacute;gimen General reglamentada por la SUNAT.</p>
<p>Nuestro objetivo es garantizar un &oacute;ptimo manejo de los fondos y bienes de la propiedad logrando maximizar la utilizaci&oacute;n de sus recursos.</p>
<p>Usted ya no tiene de qu&eacute; preocuparse. Disfrute de su tiempo</p>
</td>
<td width="60">&nbsp;</td>
<td valign="top" width="445">
    <?=Html::img("@web/img/plataforma/bnpnosotros.jpg",['width'=>445,'height'=>296]) ?>	
</tr>
</tbody>
</table></td></tr><tr height='20'><td colspan='3' ></td></tr><tr height='50'><td colspan='3' class='back'><a href='javascript:history.go(-1);'><< Regresar</a></td></tr></tr></table></div>                  <input type="hidden" name="id_cont" id="id_cont" value="1"/>
        </div>		
        </td>
       <td><?=Html::img("@web/img/plataforma/spacer.gif",['width'=>0,'height'=>0,'alt'=>""]) ?>	
           
   </tr>
   <tr>
       <td bgcolor="#FFFFFF" valign="bottom">
                </td>
       <td  colspan="2" valign="bottom" bgcolor="#FFFFFF">
                </td>
       <td bgcolor="#FFFFFF" colspan="2">
                </td>
       <td><?=Html::img("@web/img/plataforma/spacer.gif",['width'=>0,'height'=>0,'alt'=>""]) ?></td>
  </tr>
  <tr>
       <td bgcolor="#FFFFFF" colspan="5"></td>
       <td><?=Html::img("@web/img/plataforma/spacer.gif",['width'=>0,'height'=>0,'alt'=>""]) ?></td>
  </tr>
		


  
    <!--FIN DE CONTENIDO -->
  <?php echo $this->render('footer'); ?>