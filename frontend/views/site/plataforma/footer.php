 <?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Carousel;
use common\widgets\inputajaxwidget;
use yii\widgets\ActiveForm;
use common\models\LoginForm;
?>
</td>
  </tr>
  
 

 </table>

  </div>


	<div id="div_pie">
    <div id="cont_pie">
    
	     <div style="float:left;padding-top:15px;padding-left:10px;font-size:10px;width:120px;">Copyright &copy; DIAR 2013.</div>
         <div style="margin:auto;width:620px;padding-top:4px;">
	          <p>&nbsp;</p>
<p>&nbsp;</p>
<p>Calle Bolivar 298 Of. 401 - Miraflores Telf.:715 0960 /715 6417 /715 0961 /715 1485&nbsp;</p>		 </div>
		<div id="divpie_soc">Powered by <a href="http://www.bitnetperu.com" title="BITNETPERU S.A.C" target="_blank">BITNETPERU</a>
		</div>
        
	</div>
</div>
      <?php \shifrin\noty\NotyWidget::widget([
    'options' => [ // you can add js options here, see noty plugin page for available options
        'dismissQueue' => true,
        'layout' => 'center',
        'theme' => 'metroui',
        'animation' => [
            'open' => 'animated flipInX',
            'close' => 'animated flipOutX',
        ],
        'timeout' =>1000, //false para que no se borre
        'progressBar'=>true,
    ],
    'enableSessionFlash' => true,
    'enableIcon' => true,
    'registerAnimateCss' => true,
    'registerButtonsCss' => true,
    'registerFontAwesomeCss' => true,
]); ?>
<?php 
$cadena="$(document).ready(function() {
    $('#btn_enviar').on('click',function(){
       //pichicho
    v_nombre=$('#bnpnombre').val();
    v_telefono=$('#bnptelefono').val();
    v_correo=$('#bnpemail').val();
    v_mensaje=$('#bnpcomentario').val();

  $.ajax({ 
   url:'".Url::to(['site/envia-mail-cont'])."',
   type:'POST',
   dataType:'json',
   data:{nombre:v_nombre,correo:v_correo,telefono:v_telefono,mensaje:v_mensaje},    
  error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                },  
            success: function(json) {  
                  
                        var n = Noty('id');
                       if ( !(typeof json['error']==='undefined') ) {
                      
                   $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-remove-sign\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error'); 
                              }
                         if ( !(typeof json['success']==='undefined') ) {
                                    
                                $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-ok-sign\'></span>' + json['success']);
                             $.noty.setType(n.options.id, 'success');
                              } 
                               if ( !(typeof json['warning']==='undefined') ) {
                                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-info-sign\'></span>' +json['warning']);
                             $.noty.setType(n.options.id, 'warning');
                            
                              
                              } 
                     $.pjax.reload({container: '#divpie_soc'});
                 }
       }); //ajax 
        })
    })";
    
    //$cadena2="alert('hola compadre);";
   $this->registerJs($cadena, \yii\web\View::POS_END);
?>
</body>
</html>
