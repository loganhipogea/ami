 <?php
 use yii\helpers\Url;
 use yii\widgets\Pjax;
 use common\components\SesionCali;
 ?>
<li class="dropdown notifications-menu">
     <a href="<?=Url::toRoute(['/site/califica','gridName'=>'mi_calificacion','idModal'=>'buscarvalor'])?>" id="calificacion" class="dropdown-toggle botonAbre" data-toggle="dropdown">
           <i class="fa fa-money-check"></i>
                        <?php Pjax::begin(['id'=>'mi_calificacion','timeout'=>false]); ?>
                            <?php if(SesionCali::isFill()){ ?>
           <div class="notificacion" ><span class="fa fa-coins"></span></div>
                                <?php }?>
                             <?php Pjax::end(); ?>
      </a>        
</li>
              