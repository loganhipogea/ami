<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiMovimientosPre;
use frontend\modules\sigi\models\SigiMovimientosPreSearch;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * MovimientosController implements the CRUD actions for SigiMovimientosPre model.
 */
class MovimientosController extends baseController
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
     * Lists all SigiMovimientosPre models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiMovimientosPreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiMovimientosPre model.
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
     * Creates a new SigiMovimientosPre model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiMovimientosPre();
        
        
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
     * Updates an existing SigiMovimientosPre model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SigiMovimientosPre model.
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
     * Finds the SigiMovimientosPre model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiMovimientosPre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiMovimientosPre::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
    
    
    public function actionMovConfirmar(){
        
    }
    
    
    public function actionCuentasBancarias(){
         $searchModel = new \frontend\modules\sigi\models\SigiCuentasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('cuentas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionEditaCuenta($id){
       $model= \frontend\modules\sigi\models\SigiCuentas::findOne($id);
      if(is_null($model))
       throw new NotFoundHttpException(Yii::t('sigi.labels', 'No se encontró el registro'));
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['cuentas']);
        }

        return $this->render('edita_cuenta', [
            'model' => $model,
        ]); 
        
       
    }
    
  public function actionCorteCuenta($id){
    $this->layout = "install";
         $modelCuenta= \frontend\modules\sigi\models\SigiCuentas::findOne($id);  
       if(is_null($modelCuenta)){
           throw new NotFoundHttpException(Yii::t('sigi.labels', 'Esta dirección no existe'));
       }
      //echo "sas";die();
        $model= New \frontend\modules\sigi\models\SigiMovbanco();
        $model->setScenario($model::SCE_CORTE);
        $model->edificio_id=$modelCuenta->edificio_id;
        $model->cuenta_id=$modelCuenta->id;
       
         $model->tipomov=$model::TIPO_CORTE;
       $datos=[];
        if(h::request()->isPost){
           // VAR_DUMP($model->attributes);
            $model->load(h::request()->post());
             //VAR_DUMP($model->attributes);DIE();
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_movbanco', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}  
 

public function actionMovimientosBanco(){
    $searchModel = new \frontend\modules\sigi\models\SigiMovbancoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('movimientos_banco', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
}



public function actionNuevMovBanco(){
    $this->layout = "install";
           $model= New \frontend\modules\sigi\models\SigiMovbanco();
      $datos=[];
        if(h::request()->isPost){
          $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_movbanco_nuevo_editar', [
                        'model' => $model,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
}  
 


public function actionEditMovBanco($id){
    $this->layout = "install";
           $model= \frontend\modules\sigi\models\SigiMovbanco::findOne($id);
      $datos=[];
        if(h::request()->isPost){
          $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_movbanco_nuevo_editar', [
                        'model' => $model,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
}



public function actionAjaxShowConc(){
     if(h::request()->isAjax){
        $id=h::request()->post('expandRowKey');
        $model= \frontend\modules\sigi\models\SigiMovbanco::findOne($id);
        IF(is_null($model)){
            echo "No se encontr´ningún movimiento bancario para este id";
            die();
        }
        
        
        
        if($model->tipoMov->isCobranza){
             return $this->renderAjax("_expand_row_detalle_conc",['id'=>$id]);
        }elseif($model->tipoMov->isPago){
             return $this->renderAjax("_expand_row_detalle_conc_pagos",['id'=>$id]);
      
        }else{
            echo "Este movimiento no es conciliable";
        }
       // var_dump(h::request()->post(),$id);die();
         //h::response()->format = \yii\web\Response::FORMAT_JSON;
       
       
            }
   }  

public function actionCreaConc($id){
    $this->layout = "install";
    $modelMovBanco= \frontend\modules\sigi\models\SigiMovbanco::findOne($id);
    if(is_null($modelMovBanco))
     return ['success'=>2,'msg'=>'nada']; 
          
    $model= New \frontend\modules\sigi\models\SigiMovimientosPre([
        'edificio_id'=>$modelMovBanco->edificio_id,
         'cuenta_id'=>$modelMovBanco->cuenta_id,
        'idop'=>$modelMovBanco->id,
        'tipomov'=>'100',
        'activo'=>false,
        //'glosa'=>'PAGO DE CUOTA DE MANT'
    ]);
    $model->setScenario($model::SCE_CONCILIACION_PAGO);
           
      $datos=[];
        if(h::request()->isPost){
          $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_conciliacion', [
               'id'=>$id,
                        'model' => $model,
                'modelMovBanco'=> $modelMovBanco,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
} 


public function actionEditConc($id){
    $this->layout = "install";
    $model= \frontend\modules\sigi\models\SigiMovimientosPre::findOne($id);
    if(is_null($model))
     return ['success'=>2,'msg'=>'nada']; 
    $model->setScenario($model::SCE_CONCILIACION_PAGO);
           
      $datos=[];
        if(h::request()->isPost){
          $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_conciliacion', [
               'id'=>$id,
                        'model' => $model,
                //'modelMovBanco'=> $modelMovBanco,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
} 

public function actionAprobePago($id){
   
         
        if(h::request()->isAjax){
          
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $model= \frontend\modules\sigi\models\SigiMovimientosPre::findOne($id);
           if(is_null($model)){
                return ['error'=>yii::t('sta.labels','No se encontró el registro')];  
           }else{
               $model->activo=true;
               $model->save();
               return ['success'=>yii::t('sta.labels','Se aprobó el pago del recibo')];   
           }
        }
   }
public function actionUnAprobePago($id){
   
         
        if(h::request()->isAjax){
          
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $model= \frontend\modules\sigi\models\SigiMovimientosPre::findOne($id);
           if(is_null($model)){
                return ['error'=>yii::t('sta.labels','No se encontró el registro')];  
           }else{
               /*
                * Verificando primero que no tenga registros facturaciones 
                * en el siguiente mes. Si los tiene ya no se podría dar marcha atras
                */
               if(!$model->kardex->facturacion->hasNextFacturacionWithDetail()){
                    $model->activo=false;
                    $model->save();
                    return ['warning'=>yii::t('sta.labels','Se desaprobó el pago del recibo')]; 
               }else{
                   return ['error'=>yii::t('sta.labels','Ya no puede deshacer este registro, existe una facturacion del mes siguiente que depende de este valor')];  
               }
                
           }
        }
   }

   
 public function actionAttachVoucher($id){
   
         
        if(h::request()->isAjax){
          
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $model= \frontend\modules\sigi\models\SigiMovimientosPre::findOne($id);
           if(is_null($model)){
                return ['error'=>yii::t('sta.labels','No se encontró el registro')];  
           }else{
               if($model->refreshAttachment()){
                    return ['success'=>yii::t('sta.labels','Se adjuntó el voucher del usuario')]; 
           
               }  else{
                    return ['error'=>yii::t('sta.labels','No se encontró el voucher del usuario o se presentó un error al intentar adjuntarlo')]; 
           
               }             
                  }
        }
   }

   
 public function actionCreaPago($id){
    $this->layout = "install";
    $modelMovBanco= \frontend\modules\sigi\models\SigiMovbanco::findOne($id);
    if(is_null($modelMovBanco))
     return ['success'=>2,'msg'=>'nada']; 
          
    $model= New \frontend\modules\sigi\models\SigiMovimientospago([
        'edificio_id'=>$modelMovBanco->edificio_id,
         'cuenta_id'=>$modelMovBanco->cuenta_id,
        'idop'=>$modelMovBanco->id,
        'tipomov'=>'500',
        'activo'=>false,
        //'glosa'=>'PAGO DE CUOTA DE MANT'
    ]);
    $model->setScenario($model::SCE_CONCILIACION_PAGO);
           
      $datos=[];
        if(h::request()->isPost){
          $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_conciliacion_pago', [
               'id'=>$id,
                        'model' => $model,
                'modelMovBanco'=> $modelMovBanco,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
} 


public function actionEditPago($id){
    $this->layout = "install";
    $model= \frontend\modules\sigi\models\SigiMovimientosPago::findOne($id);
    if(is_null($model))
     return ['success'=>2,'msg'=>'nada']; 
    $model->setScenario($model::SCE_CONCILIACION_PAGO);
           
      $datos=[];
        if(h::request()->isPost){
          $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $model->save();
                return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_conciliacion_pago', [
               'id'=>$id,
                        'model' => $model,
                //'modelMovBanco'=> $modelMovBanco,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
} 
   
  
public function actionAprobePagoSi($id){
   
         
        if(h::request()->isAjax){
          
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $model= \frontend\modules\sigi\models\SigiMovimientospago::findOne($id);
           if(is_null($model)){
                return ['error'=>yii::t('sta.labels','No se encontró el registro')];  
           }else{
               $model->activo=true;
               $model->save();
               return ['success'=>yii::t('sta.labels','Se aprobó el pago del recibo')];   
           }
        }
   }
public function actionUnAprobePagoSi($id){
   
         
        if(h::request()->isAjax){
          
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $model= \frontend\modules\sigi\models\SigiMovimientospago::findOne($id);
           if(is_null($model)){
                return ['error'=>yii::t('sta.labels','No se encontró el registro')];  
           }else{
               /*
                * Verificando primero que no tenga registros facturaciones 
                * en el siguiente mes. Si los tiene ya no se podría dar marcha atras
                */
              // if(!$model->kardex->facturacion->hasNextFacturacionWithDetail()){
                    $model->activo=false;
                   if(!$model->save())
                     return ['error'=>yii::t('sta.labels',$model->getFirstError())]; 
                    return ['warning'=>yii::t('sta.labels','Se desaprobó el pago')]; 
               //}else{
                  // return ['error'=>yii::t('sta.labels','Ya no puede deshacer este registro, existe una facturacion del mes siguiente que depende de este valor')];  
               }
                
           }
        }
   
public function actionDeleteVoucher($id){
     if(h::request()->isAjax){          
             h::response()->format = \yii\web\Response::FORMAT_JSON;           
                $model= $this->findModel($id);
                $model->deleteAllAttachments();
             return ['warnig'=>yii::t('sta.labels','Se borraron los adjuntos')];
                
        }
   }
   
}
