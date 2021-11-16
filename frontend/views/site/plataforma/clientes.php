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
                  <div><table width='100%' align='center' border='0' cellspacing='0' cellspading='0'><tr><td class='lineahead' colspan='3' >&nbsp;&nbsp;<a href='index.php'>INICIO</a> - NUESTROS CLIENTES</td></tr><tr ><td style='width:420px;  padding-top:10px;' class='titcontenido' >&nbsp;</td><td style='float:right;width:370px;'> 
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
						</td></tr><tr><td style='width:850px;position:absolute;  padding-left:30px;' class='titcontenido'>NUESTROS CLIENTES</td></tr></tr><tr ><td valign='top' colspan='3' class='classcontenido'><p><span style="font-size: xx-small; font-family: book antiqua, palatino; color: #333333;">&nbsp;&nbsp;</span></p>
<table style="width: 970px; margin-right: auto; margin-left: auto;" border="0" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-size: xx-small; font-family: book antiqua, palatino; color: #888888;">
        <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;&nbsp;BERTLING LOGISTIC PER&Uacute; SAC</span></p>
</td>
<td width="451">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
        <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;CENTRO EMPRESARIAL TRIAL</span></p>
</td>
<td rowspan="11" width="451">
<p><span style="color: #333333; font-family: book antiqua, palatino; font-size: xx-small;"><?=Html::img("@web/img/plataforma/bnpclientess.jpg",['width'=>320, 'alt'=>0,'height'=>420 ]) ?></span></p>
</td>
</tr>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
         <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp; CENTRO COMERCIAL MALVINAS</span></p>
</td>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">&nbsp;<img src="imagen/bnpicon_naranja.jpg" alt="" width="13" height="9" border="0" />&nbsp;CENTRO EMPRESARIAL VOLTARE</span></p>
</td>
</tr>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
 <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;CENTRO EMPRESARIAL BASADRE</span></p>
</td>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
 <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;CENTRO EMPRESARIAL VISION TOWER</span></p>
</td>
</tr>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
     <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;CENTRO EMPRESARIAL&nbsp;DEL PARK I</span></p>
</td>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
    <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp; CONDOMINIO NUEVO CERCADO</span></p>
</td>
</tr>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
 <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;CENTRO EMPRESARIAL&nbsp;DEL PARK II</span></p>
</td>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
     <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;EURONA PERU SAC</span></p>
</td>
</tr>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
         <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;CENTRO EMPRESARIAL&nbsp;JOSE PARDO</span></p>
</td>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
         <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;MERKUR GAMING PER&Uacute; SAC</span></p>
</td>
</tr>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
         <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;CENTRO EMPRESARIAL&nbsp;NEXUS TOWER<br /></span></p>
</td>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
         <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp; PLATINO VIVENDAS</span></p>
</td>
</tr>
<tr>
<td class="fs3" width="406" height="30">
<p><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">
         <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        
        &nbsp;&nbsp;CENTRO EMPRESARIAL NUEVO TRIGAL&nbsp;</span></p>
<p><span style="color: #888888; font-family: book antiqua, palatino; font-size: xx-small;">
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;TORRE A &nbsp;-&nbsp;&nbsp;TORRE B</span></p>
</td>
<td class="fs3" width="406" height="30"><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">&nbsp;
         <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
        &nbsp;&nbsp;PROYECTO VIEW</span></td>
</tr>
<tr>
<td class="fs3" width="406" height="30"><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">&nbsp;
        <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
         &nbsp;CENTRO EMPRESARIAL PLATINO</span></td>
<td class="fs3" width="406" height="30"><span style="font-family: book antiqua, palatino; font-size: xx-small; color: #888888;">&nbsp;
        <?=Html::img("@web/img/plataforma/bnpicon_naranja.jpg",['width'=>13, 'alt'=>0,'height'=>9 ,'border'=>0]) ?>
         &nbsp; VIVENDAS ACACIAS</span></td>
</tr>
</tbody>
</table></td></tr><tr height='20'><td colspan='3' ></td></tr><tr height='50'><td colspan='3' class='back'><a href='javascript:history.go(-1);'><< Regresar</a></td></tr></tr></table></div>                  <input type="hidden" name="id_cont" id="id_cont" value="4"/>
        </div>		
        </td>
       <td><img src="imagen/spacer.gif" width="0" height="0" border="0" alt="" /></td>
   </tr>
   <tr>
       <td bgcolor="#FFFFFF" valign="bottom">
                </td>
       <td  colspan="2" valign="bottom" bgcolor="#FFFFFF">
                </td>
       <td bgcolor="#FFFFFF" colspan="2">
                </td>
       <td><img src="imagen/spacer.gif" width="0" height="0" border="0" alt="" /></td>
  </tr>
  <tr>
       <td bgcolor="#FFFFFF" colspan="5"></td>
       <td><img src="imagen/spacer.gif" width="0" height="0" border="0" alt="" /></td>
  </tr>
		

  
  
  
  
  
  
		

  
  
    <!--FIN DE CONTENIDO -->
  
  <?php echo $this->render('footer');  ?>
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  




