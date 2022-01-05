<?php
namespace frontend\modules\sigi\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAssetResidentes extends AssetBundle
{
 public $basePath = '@webroot';
    public $baseUrl = '@web';
     public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
       // 'css/app.css',
        //'css/site.css',
        
    ];
    public $js = [
        'js/plataforma/jquery.lightSlider.js'
         /*'js/jquery-ui.js',
         'js/modal.js',
          'js/select2.js',*/
       //'js/residentes/jquery.min.js',
        //'js/residentes/bootstrap.min.js'
        
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
       '\rmrevin\yii\fontawesome\AssetBundle'
    ];
}
