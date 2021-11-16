<?php
namespace common\actions;
use common\helpers\h;
use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionSelectImage extends \yii\base\Action
{
	
	public function run()
	{
         
        $clase=str_replace('_','\\',h::request()->get('nombreclase'));
        $isImage=h::request()->get('isImage');
        $id=h::request()->get('modelid');
        $ext=h::request()->get('extension');
       //$idGrilla=h::request()->get('idGrilla');
        if(!is_numeric($id))
          throw new \yii\base\Exception(Yii::t('base.errors', 'Id is invalid'));
        $this->controller->layout = "install";
       // $nombremodal=
        $model = $clase::find()->where(['id'=>$id])->one();
        /* echo $model->fecha;
         echo "<br>";*/
         //$model->fecha=$model::SwichtFormatDate($model->fecha, 'date', false);
         //echo $model->fecha;*/
         //$model->attributes=$model->getOldAttributes();
        yii::error('seguimiento al modal');
        if (h::request()->isPost && $model->save()) {
             yii::error('reques es post y grabo');
           // h::request()->get('idModal');die();
            //echo \yii\helpers\Html::script("$('#createCompany').modal('hide'); window.parent.$.pjax({container: '#grilla-contactos'})");
            yii::error('closemodal');
             $this->controller->closeModal('buscarvalor');
        
        } else {
             yii::error('lo contrario a  reques es post y grabo');
            if($model->hasErrors()){
                 yii::error('El modelo tienje errores ');
                 yii::error($model->getErrors());
                //print_r($model->getErrors());die();
            }
          if(!is_null($ext)){
              $allowedExtensions=json_decode($ext);
              if(!is_null($allowedExtensions) && is_array($allowedExtensions) ){
                  foreach($allowedExtensions as $index=>$ext){
                      $allowedExtensions[$index]=str_replace('.','',$ext);
                  }
                 
              }else{
                 $allowedExtensions=[str_replace('.','',$ext)];   
              }
            
          }else{
            $allowedExtensions=($isImage==1)?['jpg','png','gif','jpeg']:['doc','docx','pdf','xls','xlsx','csv','txt','ppt','pptx'];  
          }
           yii::error('Renderizando la vista  ');
            return $this->controller->render('/comunes/attachFile', [
                        'model' => $model,
                 'allowedExtensions' => $allowedExtensions,
                        //'vendorsForCombo' => $vendorsForCombo,
            ]);
        }

        /* $type = $request['type'];
          $category_selector = false;
          if (request()->has('category_selector')) {
          $category_selector = request()->get('category_selector');
          }
          $rand = rand(); */



        /* $modelclipro=$this->findModel($id);
          $model = new Contactos();
          $html = $this->render('modal_contactos',
          ['model'=>$model,
          'aleatorio'=>rand(),
          'titulo'=>'hola amigos']);
          return json_encode([
          'success' => true,
          'error' => false,
          'message' => 'null',
          'html' => $html,
          ]);
          }
         */   
          
             }
}