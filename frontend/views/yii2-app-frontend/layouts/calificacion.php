 <?php
 use yii\helpers\Url;
 ?>
<li class="dropdown notifications-menu">
                    <a href="<?=Url::toRoute('/site/califica')?>" id="calificacion" class="dropdown-toggle botonAbre" data-toggle="dropdown">
                        <i class="fa fa-money-check"></i>
                        <?php Pjax::begin(['id'=>'mi_calificacion','timeout'=>false]); ?>
                            <?php if($cuantos >0){ ?>
                                <div class="notificacion" ><?=$cuantos?></div>
                                <?php }?>
                             <?php Pjax::end(); ?>
                    </a>
                    </a>
                   
</li>
              