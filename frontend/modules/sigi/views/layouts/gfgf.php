    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

    <html xmlns="http://www.w3.org/1999/xhtml">

        <head>

            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

            <title>:: ADMINISTRACION DIAR GESTION ::</title>

            <meta name="keywords" content="dia,operacion,gestion,inmobiliaria,administracion,propiedad,centro,empresarial,comercial,condominio,club,playa" />

            <meta name="description" content="DIAR Operacion y gestion Inmobiliaria. Administracion de propiedades, centros empresariales, Centros Comerciales, Condominios, Clubs de Playa" />

            <link rel="stylesheet" href="estilos/bnpsite.css" type="text/css"  />

            <link href="estilos/dropdown/dropdown.css" media="all" rel="stylesheet" type="text/css" />

            <link href="estilos/dropdown/themes/bnpsite/default.ultimate.css" media="all" rel="stylesheet" type="text/css" />   

            <link rel="stylesheet" href="estilos/jcstyle.css" type="text/css"  />

            

			<script type="text/javascript" src="lib/jquery/jquery.js"></script>

            <script type="text/javascript" src="lib/bnpsajaxweb.js"></script>

            <script type="text/javascript" src="lib/bnpsgeneralw.js"></script>

            <script language="javascript" type="text/javascript" src="lib/bnpsusrw.js"></script>

           

            <script type="text/javascript" src="lib/jquery/jquery-cycle.js"></script>

            <script src="lib/jquery/jquery.innerfade.js" type="text/javascript"></script>

           

           

            <script src="lib/jcarousellite_1.0.1c4.js" type="text/javascript"></script>

            <script type="text/javascript" src="lib/bnpsitelb.js"></script>

            

            <link rel="stylesheet" type="text/css" href="componentes/galeria/lib/jcarrusel/skins/tango/skin.css" />

            <script type="text/javascript" src="componentes/galeria/lib/jcarrusel/lib/jquery.jcarousel.min.js"></script>

			<script type="text/javascript" language="javascript" src="lib/js-menu/jquery.dropdownPlain.js"></script>       

            <script type="text/javascript" src="lib/jquery/jquery.inf.js"></script>





			<script language="javascript" type="text/javascript" >

               

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

					

					
	

					 jQuery('#mycarousel').jcarousel({

							auto:3,

							wrap:'last',

							visible: 3, 	

							scroll:1,

							animation:1000

						});

					  	

                                $('#anicentral').innerfade({
        	speed: 'slow',
            timeout: 5000,
            type: 'random',
            containerheight: '349px'
        });
                    $('#ciclo').cycle({
            fx: 'turnDown',
            delay: 1000,
            timeout: 000            });
          
        
                    });

            </script>

        </head>

        <body bgcolor="#ffffff" style="margin:auto" onload=" preCarga('imagen/bnpdivder.png','imagen/bnpdivizq.png','imagen/bnpcurva.png','imagen/bnpedificio.png','imagen/bnpsbacknoti.jpg','imagen/bnppropietario.png');">
            <form id="frmTemplate" name="frmTemplate" method="post" action="">
                <table border="0" cellpadding="0" cellspacing="0" width="1100" align="center" style="position:relative;background:#FFF;" >
                   <tr>     
   <td colspan="3">
			<div id="head">
			     <div id="alerta">Usted tiene un nuevo mensaje en la bandeja de entrada<br /> <a href='bnpscorreo.php'><strong>ir a la bandeja</strong></a><div style='float:right'><a href='#' onClick="document.getElementById('alerta').style.display='none';"><strong>cerrar</strong></a></div></div>
                <div id="div_head"></div>
                <!-- opciones superiores head -->
                        <div id="mnu_sup">
                        <a href="index.php"><div id="bnpslogo"></div><div style="height:21px;width:215px;float:left;position:absolute;z-index:60;margin-top:28px;margin-left:93px;font-family: 'trebuchet ms', geneva;font-size: x-large; color: #999999;">C. RESIDENCIAL PARQUE SAN MARTIN</div></a>
                        <div id="div_soc">
                        <a href="https://es-la.facebook.com/"><img src="imagen/bnpfbicon.jpg" height="24" width="24" border="0" /></a>
                        <a href="https://twitter.com/"><img src="imagen/bnptwittericon.jpg" height="24" width="24" border="0" /></a>					</div>
    
                         <div id="div_intra">
                                                       <a href="bnpsmapsite.php">Mapa De Sitio</a> &nbsp; / &nbsp;
                            <div id="div_login" align="left"> 
                            Aqui nombre de usuario<div id='logeado'><table border='0' width='90%' align='center' cellpadding='0' cellspacing='0'>
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
		</table></div><div id='clave' style='display:none'><table width='236' border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td width='10'>&nbsp;</td>
				<td width='90'>&nbsp;</td>
				<td width='130'>&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan='3' align='center' style='font-size:12px'><strong></strong></td>
			</tr>
			
			<tr height='22'>
				<td>&nbsp;</td>
				<td></td>
				<td><input name='txtClaAnt' type='password' id='txtClaAnt' size='20' maxlength='16'></td>
			</tr>
			
			<tr height='22'>
				<td>&nbsp;</td>
				<td></td>
				<td><input name='txtClaNue' type='password' id='txtClaNue' size='20' maxlength='16'></td>
			</tr>
			
			<tr height='22'>
				<td>&nbsp;</td>
				<td></td>
				<td><input name='txtVerClaNue' type='password' id='txtVerClaNue' size='20' maxlength='16'></td>
			</tr>
			
			<tr>
				<td colspan='3'><div id='mensaje'></div></td>
			</tr>
			
			<tr height='22'>
				<td colspan='3' align='center'>
					<input type='button' name='btnCambiar' id='btnCambiar' value='' style='cursor:pointer' onclick='grabaCambioClave(frmTemplate,"","","","")' />
					<input type='button' name='btnCancelar' id='btnCancelar' value='' onclick='mostrar_ocultar_capa("clave","logeado"); limpiarCamposCamCla()'  style='cursor:pointer'/>
				</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table></div>                            </div>	
                            <a href="bnpscorreo.php" title="Comun&iacute;quese entre vecinos del edificio">Correo</a>				
                            </div>
                        <!-- fin opciones sup -->         
                </div>
                
               <div id="div_bnpbuscar" style="float:right;">
            			<input name="bBuscar" type="text" id="bBuscar" size="22" maxlength="25" style="position:relative; width:270px;height:30px;margin-top:7px; margin-left:10px;" value="Buscar..." onBlur="if(this.value=='') this.value='Buscar...';" onFocus="if(this.value=='Buscar...') this.value='';" onKeyUp="if(getKey(event)){ document.frmTemplate.action='bnpsbuscador.php'; document.frmTemplate.submit(); }" /></div>
                
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
                        
                                    </div>
             
			</td>
  </tr>
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
                    <tr>

                        <td colspan="3" style="position:relative;background:url(imagen/fondo_contec_animac.JPG) repeat-x;" valign="top" >

                        <div id="contenedos_animac"  align="left" style="position:relative;width:1100px;height:386px;">

                        <div id="cont_anima" >

                        <div id='anicentral'>
                            <div style=''>
							<a href='#'>
							<img src='imagen/central17/banner01.jpg' border='0' width=1024 height=349 /></a>
							</div><div style=''>
							<a href='#'>
							<img src='imagen/central17/banner02.jpg' border='0' width=1024 height=349 /></a>
							</div><div style=''>
							<a href='#'>
							<img src='imagen/central17/banner03.jpg' border='0' width=1024 height=349 /></a>
							</div><div style=''>
							<a href='#'>
							<img src='imagen/central17/banner04.jpg' border='0' width=1024 height=349 /></a>
							</div>
                        </div>
                        </div>                               

                        </div>

                        </td>                        

                    </tr>

                    <tr>

                      <td colspan="3">

                    </td>

                    </tr>

                    <tr>

                   

                    <td colspan="3"  style="background:url(imagen/bnpfondobienv.jpg) no-repeat;">

                    

                    <div style="width:13px;height:259px;margin-left:-12px;margin-top:-6px;background:url(imagen/bnpsolapaizq.jpg) no-repeat;float:left;"></div>

                    

                    <div id="div_central" >

   

                               <div id="div_conte2" >

                                    <div id="bienvenido" ></div>

                               </div>

                               

                               <div id="div_enlaces" style="width:345px;margin-left:-42px;">

                                  <div class="tituloindex"><div style="float:left;margin-left:2px;">ENLACES DE INTERÉS</div><div style="width:35px;height:35px;float:right;"><img src="imagen/bnpiconenlace.jpg" /></div>

                                  </div> <div class='links'><div id='div_conenlace'><div style='float:left;height:29px;'><img src='imagen/bnpenlace.jpg' />&nbsp;&nbsp;&nbsp;</div><div id='div_tituloenlace'><a href='bnpscontenido.php?id_cont=3' style='font-size:20px;'>REGLAMENTOS Y ESTATUTOS</a></div>
				</div><div id='div_conenlace'><div style='float:left;height:29px;'><img src='imagen/bnpenlace.jpg' />&nbsp;&nbsp;&nbsp;</div><div id='div_tituloenlace'><a href='bnpscontenido.php?id_cont=4' style='font-size:20px;'>PRESUPUESTOS 2019</a></div>
				</div><div id='div_conenlace'><div style='float:left;height:29px;'><img src='imagen/bnpenlace.jpg' />&nbsp;&nbsp;&nbsp;</div><div id='div_tituloenlace'><a href='bnpscontenido.php?id_cont=1' style='font-size:20px;'>BALANCES DE INGRESOS Y GASTOS</a></div>
				</div><div id='div_conenlace'><div style='float:left;height:29px;'><img src='imagen/bnpenlace.jpg' />&nbsp;&nbsp;&nbsp;</div><div id='div_tituloenlace'><a href='bnpscuenta.php' style='font-size:20px;'>VER ESTADO DE CUENTA</a></div>
				</div></div>          

                               </div>

                      </div>

                      </div>

                      <div style="float:right;width:13px;height:259px;margin-right:-12px;margin-top:-250px;background:url(imagen/bnpsolapader.jpg) no-repeat;"></div>

                     </td>

                    </tr>

                    <tr>

                        <td colspan="3" valign="top" >

                        <div id="div_conte3">

                           <div id="div_noti">  

                               <div class="tituloindex"><div style="width:35px;height:35px;float:left;"><img src="imagen/bnpnotiico.jpg"/></div><div style="float:right;">NOTICIAS</div></div>

                                <div class="contenido">

                                    
                                </div>

                            </div> 

                            

                           <div id="div_galeria">

                           <div class="tituloindex"><div style="float:left;">GALERIA</div><div style="width:35px;height:35px;float:right;"><img src="imagen/bnpicongal.jpg" /></div></div>

<div class="contenido">

                   <div id='grilla' >
	


</div>
<input type="hidden" name="vIdOpc" id="vIdOpc" />
<input type="hidden" name="vTipo" id="vTipo" />
<input type="hidden" name="valbum" id="valbum" />
<input type="hidden" name="vIdEdif" id="vIdEdif" />
                             </div>

                             

                             </div>  

                             

                             

                        </div>

                        </td>

                    </tr>

                </table>

            </form>

            <table border="0" cellpadding="0" cellspacing="0" width="1100" align="center" style="position:relative" >

            <tr>

            <td colspan="3">

            				

            </td>

            </tr>

        

            </table>

            <!--<div id="pie_imag" ><img src="imagen/bnpbackpie.jpg" width="1100px" /></div>-->
<div id="div_pie">
				<img src="imagen/bnpbackpie.jpg" width="1100px" />
        <div id="cont_pie">		
           <div style="float:left;color:#FFFFFF;padding-top:10px;">Copyright &copy; 2014. DIAR GESTI&Oacute;N </div><div style="float:right;color:#FFFFFF;padding-top:10px;">Powered by <a href="http://www.bitnetperu.com" title="BITNETPERU S.A.C" target="_blank">BITNETPERU</a>
           </div>

        </div>
</div> 
        </body>

    </html>



