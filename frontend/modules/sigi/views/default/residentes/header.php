   <?php
   use yii\helpers\Url;
   use yii\helpers\Html;
   
   ?>
<div style="text-align: left;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style=""  class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
              <img src=" <?= yii\helpers\Url::to("@web/img/residentes/bnpslogo.jpg") ?> " />
             
            </div>
            <div style=""  class="col-lg-8 col-md-8 col-sm-8 col-xs-12 nombreedificio"> 
                  EDIFICIO
            </div>
               
      </div>
      
        <div  style="clear:right;height:auto;" class=" rayagris col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="text-align: left; clear:right;" class="col-lg-8 col-md-8 col-sm-12 col-xs-12"> 
                <i style="font-size:2em"><span class="fa fa-user"></span></i>
                JULIAN RAMIREZ TENORIO/JESSENIA ESPINOZA RIVERA
            </div>
            <div style="clear:right; text-align: center" class="col-lg-4 col-md-4 col-sm-12 col-xs-12"> 
             
            <?= Html::a('Salir', ['create'], ['class' => 'btn btn-danger']) ?>
               <?= Html::a('Cambiar clave', ['create'], ['class' => 'btn btn-warning']) ?>
            </div>
            <A HREF="SDSDD" STYLE="COLOR:BLACK;">HOLA</A>
       </div>
<div  class="rayagris col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
       <div id="div_fndmnu">                
                <ul id='nav' class='dropdown'>
                    <li id='otros'>
                       <?=Html::a('Inicio',Url::to(['/sigi/default/panel-residente']))?>
                        
                    </li>
                    <li>
                        <a href='#'  >
                            Facturación
                        </a>
                            <ul>
                                <li>
                                     <?=Html::a('Recibos',Url::to(['/sigi/default/resi-factu']))?>
                                    
                                </li>
                                <li>
                                    <a href='/frontend/web/sigi/default/resi-agua'>
                                        Consumo de agua
                                    </a>
                                </li>
                                <li>
                                     <?=Html::a('Deudores',Url::to(['/sigi/default/resi-factu']))?>
                                    
                                    
                                </li>
                            </ul>
                   </li>
                    <li>
                        <a href='bnpscontenido.php?id_cont=&opc=4'  >
                            Documentos
                        </a>
                      <ul>
                          <li>
                              <a href='bnpscontenido.php?id_cont=1&opc=4'  >
                                  Balance Ingresos/Gastos
                              </a>
                          </li>
                          <li>
                              <a href='bnpscontenido.php?id_cont=70&opc=4'  >
                                  Comunicados Enviados
                              </a>
                          </li>
                          <li>
                              <a href='bnpscontenido.php?id_cont=67&opc=4'  >
                                  Normas de Convivencia
                              </a>
                          </li>
                          <li>
                              <a href='bnpscontenido.php?id_cont=2&opc=4'  >
                                  Acuerdos
                              </a>
                          </li>
                          <li>
                              <a href='bnpscontenido.php?id_cont=4&opc=4'  >
                                  Presupuestos
                              </a>
                          </li>
                      </ul>
                    </li>
                    
                   
                </ul>
       </div>
      </div> 
