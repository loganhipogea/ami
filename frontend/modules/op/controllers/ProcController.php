<?php

namespace frontend\modules\op\controllers;

use Yii;
use frontend\modules\op\models\OpOs;
use frontend\modules\op\models\OpOsSearch;
use frontend\modules\op\models\OpProcesos;
use frontend\modules\op\models\OpProcesosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * ProcController implements the CRUD actions for OpProcesos model.
 */
class ProcController extends baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all OpProcesos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OpProcesosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OpProcesos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OpProcesos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OpProcesos();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OpProcesos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

          $searchOs = new OpOsSearch();
          $dataProviderOs = $searchOs->searchByProc(
                h::request()->queryParams,$model->id);
        
        
        
        
        
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataProviderOs'=>$dataProviderOs
        ]);
    }

    /**
     * Deletes an existing OpProcesos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OpProcesos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OpProcesos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OpProcesos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    
     public function actionModAgregaOs($id){
    $this->layout = "install";
      $model= OpProcesos::findOne($id);
      $modeldet=New \frontend\modules\op\models\OpOs();
       
       $modeldet->proc_id=$id;
           
       $datos=[];
        if(h::request()->isPost){
            
            $modeldet->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($modeldet);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $modeldet->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_os', [
                        'model' => $modeldet,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
      }
      
      
      public function actionEditaOs($id){
           $model = OpOs::findOne($id);
           if(is_null($model))
           throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
           $searchModel = new \frontend\modules\mat\models\MatVwReqSearch();
        $dataProviderMateriales = $searchModel->search_by_os($model->id,Yii::$app->request->queryParams);
          
           
           
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-os', 'id' => $model->id]);
        }ELSE{
            //PRINT_R($model->getErrors());DIE();
        }

        return $this->render('update_os', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProviderMateriales' =>$dataProviderMateriales,
           // 'dataProviderOs'=>$dataProviderOs
        ]);
      }
    
       public function actionModAgregaDetOs($id){
    $this->layout = "install";
      $model= OpOs::findOne($id);
      $modeldet=New \frontend\modules\op\models\OpOsdet();
       
       $modeldet->proc_id=$model->proc_id;
          $modeldet->os_id=$id;  
       $datos=[];
        if(h::request()->isPost){
            
            $modeldet->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($modeldet);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $modeldet->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_osdet', [
                        'model' => $modeldet,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
      }
      
       public function actionModEditOsdet($id){
    $this->layout = "install";
      $model= \frontend\modules\op\models\OpOsdet::findOne($id);
      
       $datos=[];
        if(h::request()->isPost){
            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_osdet', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
      }
      
      
      
      public function actionModalAgregaDetReq($id){
          $this->layout = "install";
          $modelPadre= \frontend\modules\op\models\OpOsdet::findOne($id);
          $model= \frontend\modules\mat\models\MatDetreq::instance();
          $model->setAttributes([
              'req_id'=>$model->detectaIdReq(),
              'os_id'=>$modelPadre->os_id,
              'detos_id'=>$modelPadre->id,  
              'tipo'=>$model::TIPO_MATERIALE,
          ]);
           $datos=[];
        if(h::request()->isPost){
            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_detreq_os', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }
      
      
       public function actionModalEditaDetReq($id){
          $this->layout = "install";
          $model= \frontend\modules\mat\models\MatDetreq::findOne($id);
           $datos=[];
        if(h::request()->isPost){
            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_detreq_os', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
     }
        
        public function actionModalAgregaDetReqLibre($id){
          $this->layout = "install";
          $modelPadre= \frontend\modules\op\models\OpOs::findOne($id);
          $model= \frontend\modules\mat\models\MatDetreq::instance();
         // var_dump($model->detectaIdReq());die();
          $model->setAttributes([
              'req_id'=>$model->detectaIdReq(),
              'os_id'=>$modelPadre->id,
              //'detos_id'=>$modelPadre->id,              
          ]);
           $datos=[];
        if(h::request()->isPost){
            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_detreq_os_libre', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }
      
       public function actionModalEditaDoc($id){
          $this->layout = "install";
          //$modelPadre= \frontend\modules\op\models\OpOsDet::findOne($id);
          $model= \frontend\modules\op\models\OpDocumentos::instance();
         // var_dump($model->detectaIdReq());die();
          
           $datos=[];
        if(h::request()->isPost){
            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_documento', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }
       public function actionModalAgregaDoc($id){
          $this->layout = "install";
          $modelPadre= \frontend\modules\op\models\OpOsDet::findOne($id);
          //var_dump($modelPadre);die();
          $model= \frontend\modules\op\models\OpDocumentos::instance();
         // var_dump($model->detectaIdReq());die();
          $model->setAttributes([
              'proc_id'=>$modelPadre->proc_id,
              'os_id'=>$modelPadre->os_id,
              'detos_id'=>$id,              
          ]);
           $datos=[];
        if(h::request()->isPost){
            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save(); 
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_documento', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }
      
      public function actionAjaxExpandOpera(){
      if(h::request()->isAjax){
        $id=h::request()->post('expandRowKey');
        $dataprovider= New \yii\data\ActiveDataProvider([
            'query'=>\frontend\modules\op\models\OpDocumentos::find()->andWhere(['detos_id'=>$id]),
        ]);
        $model= \frontend\modules\op\models\OpOsdet::findOne($id);
       // var_dump($id);die();
         //h::response()->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax("_expand_operacion",
                [
                    'id'=>$id,
                    'dataprovider'=>$dataprovider,
                    'model'=>$model
                ]);
       
            }
      }
      
   public function actionAjaxCompraDetOs($id){
       if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                if(!is_null($model= \frontend\modules\op\models\OpOsdet::findOne($id))){
                     yii::error('Encontro');
                     $model->comprar();                                     
                  } else{
                      yii::error('NO encontro');
                  }  
                return ['success'=>yii::t('sta.errors','Se creó una solicitud de compra')];
            }   
   }
}
