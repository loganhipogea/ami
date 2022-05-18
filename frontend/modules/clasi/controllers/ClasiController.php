<?php

namespace frontend\modules\clasi\controllers;

use Yii;
use frontend\modules\clasi\models\ClasiClases;
use frontend\modules\clasi\models\ClasiClasesSearch;
use frontend\modules\clasi\models\ClasiCaracSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * ClasiController implements the CRUD actions for ClasiClases model.
 */
class ClasiController extends baseController
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
     * Lists all ClasiClases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClasiClasesSearch();
        $dataprovider = $searchModel->search(Yii::$app->request->queryParams);
         $searchModelCarac = new ClasiCaracSearch();
        $dataproviderCarac = $searchModelCarac->search(Yii::$app->request->queryParams);
        
        
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataprovider' => $dataprovider,
             'searchModelCarac' => $searchModelCarac,
            'dataproviderCarac' => $dataproviderCarac,
        
        ]);
    }

    /**
     * Displays a single ClasiClases model.
     * @param string $id
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
     * Creates a new ClasiClases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClasiClases();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->codigo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClasiClases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
            return $this->redirect(['view', 'id' => $model->codigo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClasiClases model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ClasiClases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return ClasiClases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClasiClases::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
  public function actionModAgregaCara(){
    $this->layout = "install";
      $model= NEW \frontend\modules\clasi\models\ClasiCarac();
      //$modeldet=New MatDetvale();
       
       //$modeldet->vale_id=$id;
           
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
                  return ['success'=>1,'id'=>$model->codigo];
            }
        }else{
           return $this->renderAjax('_modal_crea_caracteristica', [
                        'model' => $model,
                        //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
   

 public function actionModEditaCara($id){
    $this->layout = "install";
      $model= \frontend\modules\clasi\models\ClasiCarac::findOne($id);
                 
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
                  return ['success'=>1,'id'=>$model->codigo];
            }
        }else{
           return $this->renderAjax('_modal_crea_caracteristica', [
                        'model' => $model,
                        'id' => $model->codigo,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
     public function actionModAgregaClase(){
    $this->layout = "install";
      $model= NEW \frontend\modules\clasi\models\ClasiClases();
      //$modeldet=New MatDetvale();
       
       //$modeldet->vale_id=$id;
           
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
                  return ['success'=>1,'id'=>$model->codigo];
            }
        }else{
           return $this->renderAjax('_modal_crea_clase', [
                        'model' => $model,
                        //'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
   

 public function actionModEditaClase($id){
    $this->layout = "install";
      $model= \frontend\modules\clasi\models\ClasiClases::findOne($id);
                 
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
                  return ['success'=>1,'id'=>$model->codigo];
            }
        }else{
           return $this->renderAjax('_modal_crea_clase', [
                        'model' => $model,
                        'id' => $model->codigo,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}


 public function actionUpdateClase($id)
    {
        $model = ClasiClases::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->codigo]);
        }

        return $this->render('_form', [
            'model' => $model,
        ]);
    }

    
    public function actionModCreaAsocia($id){
    $this->layout = "install";
      $modelPadre= ClasiClases::findOne($id);
      $model= NEW \frontend\modules\clasi\models\ClasiClaseCarac();
      //$modeldet=New MatDetvale();
       $model->clase_id=$modelPadre->codigo;
       //$modeldet->vale_id=$id;
           
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
                  return ['success'=>1,'id'=>$model->codigo];
            }
        }else{
           return $this->renderAjax('_modal_asocia_clase', [
                        'model' => $model,
                        'modelPadre' => $modelPadre,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
   
}
