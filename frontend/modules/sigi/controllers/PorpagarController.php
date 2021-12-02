<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiPorpagar;
use frontend\modules\sigi\models\SigiPorpagarSearch;
use frontend\modules\sigi\models\SigiPorCobrarSearch;
use frontend\modules\sigi\models\SigiSancionesSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * PorpagarController implements the CRUD actions for SigiPorpagar model.
 */
class PorpagarController extends baseController
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
     * Lists all SigiPorpagar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiPorpagarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiPorpagar model.
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
     * Creates a new SigiPorpagar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiPorpagar();
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }else{
          
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SigiPorpagar model.
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
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SigiPorpagar model.
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
     * Finds the SigiPorpagar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiPorpagar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiPorpagar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
    
    /*
     * Porgrama el pago de un documetno
     * para esto crea un registro de moivmiento pre
     */
    public function actionProgramarPago($id){
       if (h::request()->isAjax ) {
              h::response()->format = Response::FORMAT_JSON;
         $model=$this->findModel($id);
         $model->programarPago();
         if($model->hasErrors()){
             return ['error'=>yii::t('sigi.errors',$model->getFirstError())];
             
         }else{
             return ['success'=>yii::t('sigi.labels','Se ha programado el pago del documento al {fecha}',['fecha'=>$model->fechaprog])];
         }
     }
    
    }
    
   
 public function actionCreaProgPago($id){
    $this->layout = "install";
    $modelMovBanco= \frontend\modules\sigi\models\SigiPorpagar::findOne($id);
    if(is_null($modelMovBanco))
     return ['success'=>2,'msg'=>'nada']; 
          
    $model= New \frontend\modules\sigi\models\SigiPropago([
        'edificio_id'=>$modelMovBanco->edificio_id,
         //'cuenta_id'=>$modelMovBanco->cuenta_id,
        'porpagar_id'=>$modelMovBanco->id,
        //'tipomov'=>'100',
        'activo'=>true,
        //'glosa'=>'PAGO DE CUOTA DE MANT'
    ]);
    //$model->setScenario($model::SCE_CONCILIACION_PAGO);
           
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
           return $this->renderAjax('_modal_progpago', [
               'id'=>$id,
                        'model' => $model,
                'modelMovBanco'=> $modelMovBanco,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
} 


public function actionEditProgPago($id){
    $this->layout = "install";
    $model= \frontend\modules\sigi\models\SigiPropago::findOne($id);
   // var_dump();
    if(is_null($model))
     return ['success'=>2,'msg'=>'nada']; 
    //$model->setScenario($model::SCE_CONCILIACION_PAGO);
           
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
           return $this->renderAjax('_modal_progpago', [
               'id'=>$id,
                        'model' => $model,
                //'modelMovBanco'=> $modelMovBanco,
               'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        ]);  
        } 
}    
    

public function actionCreateMulta(){
    $model = new \frontend\modules\sigi\models\SigiSanciones();
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update-multa', 'id' => $model->id]);
        }else{
           //var_dump($model->load(Yii::$app->request->post()),$model->getFirstError());die(); 
       
        }
        return $this->render('create_multa', [
            'model' => $model,
        ]);
}

public function actionUpdateMulta($id){
    $model =\frontend\modules\sigi\models\SigiSanciones::findOne($id);
    if(is_null($model))
    throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
   
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update-multa', 'id' => $model->id]);
        }else{
            }
        return $this->render('update_multa', [
            'model' => $model,
        ]);
}
  
public function actionIndexMulta(){
    $searchModel = new SigiSancionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_multa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
   }

 /**
     * Lists all SigiPorpagar models.
     * @return mixed
     */
    public function actionIndexCobrar()
    {
        $searchModel = new SigiPorCobrarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_cobrar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

     public function actionCrearCobro()
    {
        
             
        $model = new \frontend\modules\sigi\models\SigiPorCobrar();
        if(!is_null($imp= h::request()->get('inputado')))
           $model->setScenario($model::SCE_IMPUTADO);
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        //VAR_DUMP($model->load(Yii::$app->request->post()),$model->save(),$model->getErrors());DIE();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-cobrar', 'id' => $model->id]);
        }else{
          
        }
        return $this->render('create_cobrar', [
            'model' => $model,
        ]);
    }
    
   public function actionUpdateCobrar($id)
    {
        $model = \frontend\modules\sigi\models\SigiPorCobrar::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-cobrar', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('update_cobrar', [
            'model' => $model,
        ]);
    }
  public function actionViewCobrar($id)
    {
        return $this->render('view_cobrar', [
            'model' => \frontend\modules\sigi\models\SigiPorCobrar::findOne($id),
        ]);
    }
    
    
  public function actionCrearPago()
    {  $model = new \frontend\modules\sigi\models\SigiPorpagar();
        if(!is_null($imp= h::request()->get('inputado')))
           $model->setScenario($model::SCE_IMPUTADO);
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-pagar', 'id' => $model->id]);
        }else{
          //PRINT_R($model->getErrors());die();
        }
        return $this->render('create_cobrar', [
            'model' => $model,
        ]);
    }
    
   public function actionUpdatePagar($id)
    {
        $model = \frontend\modules\sigi\models\SigiPorpagar::findOne($id);
         if($model->unidad_id>0)
             $model->setScenario($model::SCE_IMPUTADO);
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-pagar', 'id' => $model->id]);
        }else{
           // print_r($model->getErrors());die();
        }

        return $this->render('update_pagar', [
            'model' => $model,
        ]);
    } 
    
    public function actionViewPagar($id)
    {
        return $this->render('view_pagar', [
            'model' => \frontend\modules\sigi\models\SigiPorpagar::findOne($id),
        ]);
    }
    
}
