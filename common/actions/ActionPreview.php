<?php
namespace common\actions;
use common\helpers\h;
use yii\helpers\Json;
use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionPreview extends \yii\base\Action
{
	
	public function run()
	{
         $index=h::request()->get('index',0);
         $options=Json::decode(h::request()->get('options'),Json::encode(['width'=>300,'height'=>300]));
        $clase=str_replace('_','\\',h::request()->get('nombreclase'));
        
       $this->controller->layout = "install";
       // $nombremodal=
        $model = $clase::find()->where(['id'=>$id])->one();
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
       
             }
}