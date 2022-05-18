<?php

namespace frontend\modules\op\controllers;

use Yii;
use frontend\modules\op\models\OpTareo;
use frontend\modules\op\models\OpTareoSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * TareoController implements the CRUD actions for OpTareo model.
 */
class TareoController extends baseController
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
     * Lists all OpTareo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OpTareoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OpTareo model.
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
     * Creates a new OpTareo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OpTareo();
        
        
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
     * Updates an existing OpTareo model.
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
        $searchModel = new \frontend\modules\op\models\OpTareodetSearch();
        $dataProviderCuadrilla = $searchModel->search($model->id,Yii::$app->request->queryParams);
        return $this->render('update', [
            'model' => $model,
            'dataProviderCuadrilla' =>$dataProviderCuadrilla,
        ]);
    }

    /**
     * Deletes an existing OpTareo model.
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
     * Finds the OpTareo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OpTareo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OpTareo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    
      public function actionModalAgregaLibro($id){
          $this->layout = "install";
          $modelPadre= \frontend\modules\op\models\OpTareo::findOne($id);
          //var_dump($modelPadre);die();
          $model= new \frontend\modules\op\models\OpLibro();
         // var_dump($model->detectaIdReq());die();
          $model->setAttributes([
              'tareo_id'=>$modelPadre->id,                           
          ]);
          $model->califica();
         // print_r($model->attributes);die();
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
           return $this->renderAjax('_modal_crea_libro', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
          
      }
      
      public function actionModalEditaLibro($id){
          $this->layout = "install";
          //$modelPadre= \frontend\modules\op\models\OpTareo::findOne($id);
          //var_dump($modelPadre);die();
          $model= \frontend\modules\op\models\OpLibro::findOne($id);
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
           return $this->renderAjax('_modal_crea_libro', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
        
        
       
          
      }
        
       public function actionModalAgregaPersona($id){
          $this->layout = "install";
          $modelPadre= \frontend\modules\op\models\OpTareo::findOne($id);
          //var_dump($modelPadre);die();
          $model= new \frontend\modules\op\models\OpTareodet();
         // var_dump($model->detectaIdReq());die();
          $model->setAttributes([
              'tareo_id'=>$modelPadre->id,                           
          ]);
          $model->califica();
          
         // print_r($model->attributes);die();
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
           return $this->renderAjax('_modal_agrega_persona', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }     
      }
      
       public function actionModalEditaPersona($id){
          $this->layout = "install";
          //$modelPadre= \frontend\modules\op\models\OpTareo::findOne($id);
          //var_dump($modelPadre);die();
          $model= \frontend\modules\op\models\OpTareodet::findOne($id);
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
           return $this->renderAjax('_modal_agrega_persona', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
        
        
       
          
      }
      
}

