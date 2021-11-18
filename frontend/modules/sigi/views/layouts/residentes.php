<?php
use yii\helpers\Html;
use yii\helpers\Url;
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

  

      ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="administracion,meotegnia consultores,julian ramirez tenorio, inmuebles, administracion de inmuebles, diar, operacion, gestion, inmobiliaria, centro comercial, condominio, playa, empresarial, comercial, club" />



        <?= Html::csrfMetaTags() ?>
        
        
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
   <body bgcolor="#ffffff" style="margin:auto">
       
    <?php $this->beginBody() ?>
          <table border="0" cellpadding="0" cellspacing="0" width="1100" align="center" style="position:relative;background:#FFF;" >
               <tr>     
                    <td colspan="3">
			<div id="head">
			      <div id="div_head"></div>
                <!-- opciones superiores head -->
                        <div id="mnu_sup">
                           <a href="index.php">
                               <div id="bnpslogo" style="width: 265px;
                                    height: 88px;                                  
                                    float: left;
                                    margin-top: 10px;
}                                   ">
                                  LOGO 
                               </div>
                                    <div style="height:21px;width:215px;float:left;position:absolute;z-index:60;margin-top:28px;margin-left:93px;font-family: 'trebuchet ms', geneva;font-size: x-large; color: #999999;">
                                        C. RESIDENCIAL PARQUE SAN MARTIN
                                    </div>
                           </a>    
                         <div id="div_intra">
                                       
                            <div id="div_login" align="left"> 
                                   Aqui nombre de usuario
                              <div id='logeado'>
                                  <table border='0' width='90%' align='center' cellpadding='0' cellspacing='0'>
                                        <tr>
                                                <td width='4%'>&nbsp;</td>
                                                <td width='96%'>
                                                <strong> </strong>
                                                </td>
                                          </tr>
			
                                            <tr>
                                                <td height='20'>&nbsp;</td>
                                                <td>EFREN GROVER CABRERA VITO / Maria Isabel Llacsahuanga Romero </td>
                                            </tr>
			
                                            <tr>
                                                <td height='20' align='center'>&nbsp;</td>
                                                <td align='center'>
                                                <input type='button' name='salir' id='salir' value='' onclick='location.href="bnpssalirw.php"' style='cursor:pointer' />
                                                </td>
                                            </tr>
			
                                            <tr>
                                                <td height='12' colspan='2' align='center' valign='middle' ><div class='linea'></div></td>
                                            </tr>
			
                                            <tr>
                                                <td height='18'></td>
                                                <td><a href='#' onclick='mostrar_ocultar_capa("logeado","clave")'></a></td>
                                            </tr>
			
                                            <tr>
                                                <td height='12' colspan='2' align='center' valign='middle'><div class='linea'></div></td>
                                            </tr>
                                  </table>
                                      
                              </div>
                                         
               </div>	
                          
           </div>
                        <!-- fin opciones sup -->         
      </div>
                
                            
			           <div id="nombre_logeo">EFREN GROVER CABRERA VITO / Maria Isabel Llacsahuanga Romero &nbsp;
                            <span style=" text-align:right;"><a href="bnpssalirw.php" title="Cerrar Sessi&oacute;n" id="Salir"  style="color:#C81D15; text-align:right;">[ Cerrar Sesi&oacute;n ]</a></span>
                            &nbsp;
                            <span style=" text-align:right;"><a href="javascript:;" title="Cambiar Clave" id="cclave"  style="color:#696063; text-align:right;">[ Cambiar Clave ]</a></span>
                            <div id="div_cambioclave" align="left"> 
                        	
                <div id="cambiocla">
                  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
                       <tr>
                            <td height="25">&nbsp;</td>
                            <td valign="bottom"><span >Clave anterior</span></td>
                        </tr>
                        <tr>
                            <td width="192"><strong>&nbsp;&nbsp;&nbsp;</strong></td>
                            <td width="381"><input type="password" name="txtV1" id="txtV1" size="25" maxlength="20" />                    </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><span >Nueva clave</span></td>
                        </tr>
                        <tr>
                            <td width="192"><strong>&nbsp;&nbsp;&nbsp;</strong></td>
                            <td><input name="txtV2" type="password" id="txtV2" size="25" maxlength="16"  />                    </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Verificar clave</td>
                	</tr>
                        <tr>
                  	<td>&nbsp;</td>
                  	<td><input name="txtV3" type="password" id="txtV3" size="25" maxlength="16"  /></td>
                	</tr>
                  <tr>
                    <td colspan="2"><div id="mensajex" align="center">&nbsp;</div></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center">&nbsp;&nbsp;
                    <input type="button" value="Cambiar" onclick="grabar_nuevaClave('bnpscamcla.php');" class="boton_login"/>
				    <input type="button" class="boton_login" onclick="limpiarCamposCamCla();" id="btnCerrar2" value="Cancelar"  style="cursor:pointer; margin-left:5px"/></td>
                  </tr>
                  <tr>
                  	<td colspan="2" align="center">&nbsp;</td>
                	</tr>
                  <tr>
                    <td colspan="2" align="center"></td>
                  </tr>
                            </table>
                            </div>
             
                            </div>
						</div>
                        
                                   
             
			</td>
              </tr>
      <!-- INICIO DEL MENU -->
              <tr>
                        <td colspan="3">
                            <div id="div_fndmnu">
                                <img src="imagen/bnplineasup.jpg" width="1100px"/>
                                      <ul id='nav' class='dropdown'>
                                          <li id='otros'>
                                           <a href='index.php?opc=998' class='seleccionado'>INICIO</a>
                                          </li>
                                          <li>
                                            <a href='bnpscontenido.php?id_cont=&opc=1'  >REGLAMENTOS</a>                                          
                                                <ul>
                                                    <li>
                                                        <a href='bnpscontenido.php?id_cont=3&opc=1'  >Reglamentos y Estatutos</a>
                                                    </li>
                                                    <li>
                                                        <a href='bnpscontenido.php?id_cont=4&opc=1'  >Junta Directiva</a>
                                                    </li>
                                                    <li>
                                                        <a href='bnpscontenido.php?id_cont=6&opc=1'  >Acuerdos de Asamblea</a>
                                                    </li>
                                                </ul>
                                         </li>
                                         <li>
                                                 <a href='bnpscontenido.php?id_cont=&opc=4'  >DEL EDIFICIO</a>
                                                  <ul>
                                                      <li>
                                                          <a href='bnpscontenido.php?id_cont=1&opc=4'  >Balance de Ingresos y Gastos</a>
                                                      </li>
                                                      <li>
                                                          <a href='bnpscontenido.php?id_cont=70&opc=4'  >Comunicados Enviados</a>
                                                      </li>
                                                      <li>
                                                          <a href='bnpscontenido.php?id_cont=67&opc=4'  >Normas de Convivencia</a>
                                                      </li>
                                                      <li><a href='bnpscontenido.php?id_cont=2&opc=4'  >Recibo de Mantenimiento</a>
                                                      </li>
                                                      <li><a href='bnpscontenido.php?id_cont=4&opc=4'  >Presupuestos</a>
                                                      </li>
                                                  </ul>
                                         </li>
                                        <li>
                                           <a href='#'  >DOCUMENTOS</a>
                                         </li>
                                        <li id='otros2'>
                                             <a href='bnpscontactenos.php?opc=999' >CONT&Aacute;CTENOS</a>
                                         </li>
                                      </ul>
                               </div>
                        </td>
                    </tr>
          </table>
    <?php $this->endBody() ?>
  </body>
    </html>
    <?php $this->endPage() ?>



