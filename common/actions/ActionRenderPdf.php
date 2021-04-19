<?php
namespace common\actions;
use common\helpers\h;
use common\models\File;
use common\helpers\FileHelper;
use yii\helpers\Json;
use yii;

class ActionRenderPdf extends \yii\base\Action
{
	
	public function run()
	{
            
            
          $idFile=Json::decode(h::request()->get('idFile'));
         // var_dump($idFile);die();
          $model=File::findOne($idFile);
          if(!is_null($model)){
               $width=h::request()->get('width',700);
        $height=h::request()->get('height',900);
       return $this->controller->renderPartial('/comunes/view_pdf', [
                        'urlFile' => $model->urlTempWeb,
                         'width' => $width,
                            'height' => $height,
            ]);
          }else{
              echo 'no hay id para este archivo';
          }
       // echo $urlFile; die();
       
            //FileHelper::clearTempWeb();
      // return $contenido;
        }

       
}