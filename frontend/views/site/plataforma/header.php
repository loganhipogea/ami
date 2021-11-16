<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
use common\widgets\inputajaxwidget;
use yii\widgets\ActiveForm;
use common\models\LoginForm;
?>



<title>:: DIAR - Operación y Gestión Inmobiliaria ::</title>





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
                
                <div style="display:table;" >
                 <div style="display:table-row;" >
                    <?php 
                    $model=new LoginForm();
                    $form = ActiveForm::begin(['id' => 'form-database',
                        'action'=>['site/login-residente'],
                        'enableAjaxValidation'=>true
                        ]);
                    $style="  border: 1px
                    solid #DBDADA !important;
                    display:table-cell !important;
                    font-family: Arial, Helvetica, sans-serif !important;
                    color: #92938D !important;
                    font-size: 12px !important;
                    height: 18px !important;";
                    ?>
                    <div style="display:table-cell; vertical-align: middle;" >               
           <?= $form->field($model, 'username')->textInput(['style'=>$style])->label(false)  ?>
                    </div>
                    <div style="display:table-cell; vertical-align: middle;" > 
                        
               <?= $form->field($model, 'password')->passwordInput(['style'=>$style])->label(false) ?>
                         </Div>                   
                       <div style="display:table-cell; vertical-align: middle;" > 
                            <?= Html::submitButton(Yii::t('base.verbs', 'Ingresar'), ['id' => 'next-button','style' => 'cursor: pointer;background: #EB870F; width: 60px;height: 24px;border: 1px solid #AACFE4;color: #FFF;']) ?>
                        </div> 
            <?php ActiveForm::end(); ?> 
                 </div>
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
          <div align="left" id="div_fndmnu">
              <ul id='nav' class='dropdown'>
                  <li id='otros'>
                      <?=Html::a('INICIO',Url::to(['site/plataforma','id'=>1]))?>
                  </li>
                  <li>
                     <?=Html::a('NOSOTROS',Url::to(['site/plataforma','id'=>2]))?>
                  </li>
                  <li>
                     <?=Html::a('CLIENTES',Url::to(['site/plataforma','id'=>3]))?>
                        <ul>
                           <li>
                              <a href='bnpsservicios.php?opc=2' target="_parent" >SERVICIOS</a>
                          </li>
                      </ul>
                  </li>
                  <li id='otros2'>
                     <?=Html::a('CONT&Aacute;CTENOS',Url::to(['site/plataforma','id'=>4]))?>
                  </li>
              </ul>
          </div>        
    </td>
    </tr>

</table>
	<!-- FIN HEAD -->	

   </td>

  </tr>	
