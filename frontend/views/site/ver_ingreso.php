<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';

?>
<div class="site-login">
    <h4>Estás en otra zona</h4>

    <p style="color:#bbb;font-size: 12px;">Este mensaje sólo puede ser leído por tu dirección IP, y es temporal</p>

    <div class="row" style="text-align: center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div style="margin:100px;font-size:16px; color:#444; text-align:justify ">
                <?php echo $mensaje  ?>
            </div>
        </div>
    </div>
</div>