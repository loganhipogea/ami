<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
use common\widgets\inputajaxwidget;
use yii\widgets\ActiveForm;
use common\models\LoginForm;
?>

<?php echo $this->render('header');  ?>

  
  
  
  
  
  
  <tr>
   <td  valign="top" height="550" style="background-color:#FFFFFF;">

   <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
 
 <tr>
    <td colspan="4" align="left" class="lineaheaddiv" height="25">&nbsp;&nbsp;<a href="index.php">INICIO</a> - Cont&aacute;ctenos</td>
    </tr>
				<tr>
				<td width="480" align="center"  >
					 
     	
	<div style="position:relative;height:80px;">
			<p style="color:#F59E5A; font-size:22px;padding-left:25px;padding-top:5px;text-align:left;margin:17px 0;">Cont&aacute;ctenos
				
				</p>
                
				<div style="position:absolute;height:25px;left:26px;top:40px;width:540px;color:#919191;font-size:12px;text-align:left;">
				Use el formulario de cont&aacute;ctenos abajo para dejarnos su consulta o comentario.<br /> Le contestaremos a la brevedad posible. ¡Gracias!
                
				</div>	
      

						
			</div>
						
				      <div id="div_contac" align="center">
   
   <table  align="center" border="0" cellpadding="0" cellspacing="1"  width="100%">
      <tr>
          <td colspan="2">&nbsp;</td> 
       </tr>
       <tr>
          <td width="93" align="left"><span class="textcontacto">Nombre</span></td>
     <td  height="32" align="left" >
    <input name="bnpnombre" id="bnpnombre" size="40" maxlength="45" value="" /></td>
       </tr>

        <tr>
           <td  align="left" height="36"><span class="textcontacto">Tel&eacute;fono(s)</span></td>
     <td align="left" >
               <input name="bnptelefono" id="bnptelefono"  size="28" maxlength="28" value="" />           </td>
         </tr>
         <tr>
            <td  align="left" height="26"><span class="textcontacto"> Correo</span></td>
     <td align="left" >
                  <input name="bnpemail" id="bnpemail"  size="40" maxlength="45" value="" />
     </td>  
          </tr>
          <tr>
             <td  valign="top" align="left" height="22"><span class="textcontacto" style="position:relative;top:5px;">Consulta</span></td>
             <td align="left" valign="top">
           <span style="float:left;margin-top:6px;"> 
               <textarea name="bnpcomentario" cols="35" rows="8"  id="bnpcomentario" >
                   
               </textarea>
           </span>&nbsp;</td>   
          </tr>
          
          
         
          <tr>
              <td colspan="2" valign="top" align="center" height="30"><span>
                  <input type="button" class="boton_login"  value=" ACEPTAR " name="Enviar" id="btn_enviar"   />&nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="button" class="boton_login" value="LIMPIAR" name="Limpiar" id="Limpiar" />
                </span></td>
          </tr>
          <tr>
              <td colspan="2" align="center" >&nbsp;</td>
          </tr>
      </table>
      </div>  
				
				<input type="hidden" name="id_cont" id="id_cont" value=""/>
    				
							</td>
							
							
							
				<td width="400"  valign="top"  >
				<div style="border-left:1px solid #EEEEEE;width:1px;  height:400px;float:left;position:absolute;margin-top:80px;margin-left:0px;"></div>

				<br /><br />
	<div style="margin-right:5px;margin-top:25px;">
<!-- poniendo el google mapas-->
        
<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.pe/maps?f=d&amp;source=s_d&amp;saddr=++Calle+Bolivar+298+Of.+402+Miraflores&amp;daddr=&amp;hl=es&amp;geocode=&amp;sll=-9.243538,-75.019514&amp;sspn=20.453646,28.344727&amp;mra=ls&amp;ie=UTF8&amp;t=m&amp;ll=-12.15887,-76.95189&amp;spn=0.014683,0.018282&amp;z=15&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com.pe/maps?f=d&amp;source=embed&amp;saddr=++Calle+Bolivar+298+Of.+402+Miraflores&amp;daddr=&amp;hl=es&amp;geocode=&amp;sll=-9.243538,-75.019514&amp;sspn=20.453646,28.344727&amp;mra=ls&amp;ie=UTF8&amp;t=m&amp;ll=-12.15887,-76.95189&amp;spn=0.014683,0.018282&amp;z=15" style="color:#0000FF;text-align:left"><div style="color:#CCCCCC;text-align:center;font-weight:bold;">Ver mapa más grande</div></a></small>
       
    <!--   <img src="imagen/bnpsombra_mapa.jpg" width="411" height="18" />-->
       <p>&nbsp;</p>
<table style="width: 310px; height: 130px;">
<tbody>
<tr>
<td align="center" width="350">
<div class="esqredon" style="opossition: relative; margin-left: 40px; width: 300px; height: 110px;">
<table style="width: 340px; height: 92px;" border="0" cellspacing="0" cellpadding="0" align="center">
<tbody>
<tr>
<td style="font-size: 12px;" height="15">
<div style="text-align: center;">
<div align="left">
<div class="fs4bc">
<div align="center">Tel&eacute;fonos: 715 0960 - 715 6417</div>
</div>
</div>
</div>
</td>
</tr>
  
 <tr>
<td class="fs1" style="font-size: 12px;" align="center" valign="top" width="189" height="64"><span style="font-size: medium;">Calle Bolivar 298 Of. 402</span><span style="font-size: medium;"> Miraflores</span><br /><span style="font-size: medium;">&nbsp;&nbsp;</span></td>
</tr>
</tbody>
</table>
</div>
</td>
</tr>
</tbody>
</table>	</div>
				
				</td>
				</tr>
    </table>
  <?php echo $this->render('footer');  ?>