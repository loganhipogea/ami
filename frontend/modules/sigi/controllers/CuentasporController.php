<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiCuentaspor;
use frontend\modules\sigi\models\SigiCuentasporSearch;
use frontend\controllers\base\baseController;
use frontend\modules\sigi\models\SigiLecturasTempSearch;
use frontend\modules\sigi\models\SigiLecturasTemp;
use frontend\modules\sigi\models\forms\lecturas AS Lectura;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * CuentasporController implements the CRUD actions for SigiCuentaspor model.
 */
class CuentasporController extends baseController
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
     * Lists all SigiCuentaspor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiCuentasporSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiCuentaspor model.
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
     * Creates a new SigiCuentaspor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAsChild($id)
    {
        $this->layout = "install";
        $modelFacturacion = \frontend\modules\sigi\models\SigiFacturacion::findOne($id);
        if(is_null($modelFacturacion))
           // echo "hol";die();
         throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
       // $model->valoresDefault();
        
        $model=new SigiCuentaspor();
        $model->setScenario($model::SCENARIO_RECIBO_EXTERNO_MASIVO);
        $attributesChild=[
            'edificio_id'=>$modelFacturacion->edificio_id,
            'facturacion_id'=>$modelFacturacion->id,
             'mes'=>$modelFacturacion->mes,
            'anio'=>$modelFacturacion->ejercicio,
        ];
        $model->setAttributes($attributesChild);
        
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
           return $this->renderAjax('create_as_child', [
                        'model' => $model,
               'modelFacturacion' =>$modelFacturacion,
                       // 'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                       'idModal'=>h::request()->get('idModal'),
                       //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
        
    }

    
         
    public function actionCrearBoletaInterna()
    {
        $model = new SigiCuentaspor();
        $model->setScenario(SigiCuentaspor::SCENARIO_RECIBO_INTERNO);
        $model->valoresDefault();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
            //print_r($model->getErrors());die();
        }

        return $this->render('crear_recibo', [
            'model' => $model,
            
        ]);
    }
    
    /**
     * Updates an existing SigiCuentaspor model.
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
            yii::error($model->getErrors());
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SigiCuentaspor model.
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
     * Finds the SigiCuentaspor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiCuentaspor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiCuentaspor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
    
    
    public function actionCreateAsChildInterno($id)
    {
        $this->layout = "install";
        $modelFacturacion = \frontend\modules\sigi\models\SigiFacturacion::findOne($id);
        if(is_null($modelFacturacion))
           // echo "hol";die();
         throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
       // $model->valoresDefault();
        
        $model=new SigiCuentaspor();
        $model->setScenario($model::SCENARIO_RECIBO_INTERNO);
        $attributesChild=[
            'edificio_id'=>$modelFacturacion->edificio_id,
            'facturacion_id'=>$modelFacturacion->id,
             'mes'=>$modelFacturacion->mes,
            'anio'=>$modelFacturacion->ejercicio,
        ];
        $model->setAttributes($attributesChild);
        
        $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                yii::error('seguimiento');
                yii::error($model->attributes);
                $model->save();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_form_as_child_interno', [
                        'model' => $model,
               'modelFacturacion' =>$modelFacturacion,
                       // 'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                       'idModal'=>h::request()->get('idModal'),
                       //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
        
    }

    public function actionEditaAsChildInterno($id)
    {
        $this->layout = "install";
        $model = \frontend\modules\sigi\models\SigiCuentaspor::findOne($id);
        
        if(is_null($model))
           // echo "hol";die();
         throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
        $modelFacturacion = \frontend\modules\sigi\models\SigiCuentaspor::findOne($model->facturacion_id);
        $model->setScenario($model::SCENARIO_RECIBO_INTERNO);
        
        $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
            h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                ///yii::error('seguimiento');
                ///yii::error($model->attributes);
                $model->save();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_form_as_child_interno', [
                        'model' => $model,
               'modelFacturacion' =>$modelFacturacion,
                       // 'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                       'idModal'=>h::request()->get('idModal'),
                       //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
        
    }
     
 public function generaLecturas($id){
     $model=$this->findModel($id);
     $suministros=$model->edificio->suministros();
     $tipo=$model->colector->tipomedidor;
     foreach($suministros as $suministro){
        if($tipo==$suministro->tipo)
         SigiLecturasTemp::firstOrCreateStatic([
             'suministro_id'=>$suministro->id,
             'unidad_id'=>$suministro->unidad->id,
             'mes'=>$model->mes,
              'anio'=>$model->anio,
         ]);
     }
      $searchModel = new SigiLecturasTempSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('lecturas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
 } 
 
  public function actionEditaCobranza($id){        
         $this->layout = "install";
       $model=$this->findModel($id);
       $colector=$model->colector;
      $modelFacturacion=$model->facturacion;
      if(!$colector->isBudget()) { //Si no es presupeusto hacer algo
          if(!$colector->individual){
              $model->setScenario($model::SCENARIO_RECIBO_EXTERNO_MASIVO);
              $renderVista='create_as_child';
             
              
          }else{
              $model->setScenario($model::SCENARIO_RECIBO_INTERNO);
              $renderVista='_form_as_child_interno';
              //$renderVista='create_as_child';
             
          }
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
           return $this->renderAjax($renderVista, [
                        'model' => $model,
                        'id' => $id,
                         'modelFacturacion'=>$modelFacturacion,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
          
      } else{ //SIO es presupeusto, no hace rnad no se pued emodificar 
          echo "nada";
      }
       
       
       
    } 
   
  public function actionCreaLecturas($id){
     
      $this->layout = "install";
      $modelPadre= SigiCuentaspor::findOne($id);
      if(is_null($modelPadre)){
           echo "NOS E ECNONTRÓ EL REGISTRO";DIE();
      }
     
        /*$modelFacturacion = \frontend\modules\sigi\models\SigiFacturacion::findOne($id);
        if(is_null($modelFacturacion))
           // echo "hol";die();
         throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
       // $model->valoresDefault();*/
        
        $model=new Lectura();
        
        $datos=[];
       
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
               
                  return ['success'=>1,1];
            }
        }else{
           return $this->renderAjax('_fecha_lecturas', [
                        'model' => $model,
               'id'=>$id,
               'mes' =>$modelPadre->mes,
               'anio' =>$modelPadre->anio,
                       // 'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                       'idModal'=>h::request()->get('idModal'),
                       //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
         
   }
        
  
}
