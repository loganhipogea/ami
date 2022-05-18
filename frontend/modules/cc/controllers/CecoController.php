<?php

namespace frontend\modules\cc\controllers;

use Yii;
use frontend\modules\cc\models\CcCc;
use frontend\modules\cc\models\CcCcSearch;
use frontend\modules\cc\models\CcOrdenSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * CecoController implements the CRUD actions for CcCc model.
 */
class CecoController extends baseController
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
     * Lists all CcCc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcCcSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcCc model.
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
     * Creates a new CcCc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcCc();
        $model->activo=true;
        
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
     * Updates an existing CcCc model.
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
     * Deletes an existing CcCc model.
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
     * Finds the CcCc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CcCc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcCc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    
     public function actionModCreaCalificacion($id){
    $this->layout = "install";
    $modelCompra= \frontend\modules\cc\models\CcCompras::findOne($id);
      
    $model=New \frontend\modules\cc\models\CcGastos();
     if(h::request()->isGet){   
    $tipo=h::request()->get('tipo');
    if($tipo===$model->codigo_costo_directo()){
        $model->setScenario('SCE_'.$model->codigo_costo_directo());
    }elseif($tipo===$model->codigo_costo_indirecto()){
        $model->setScenario('SCE_'.$model->codigo_costo_indirecto());
    }elseif($tipo===$model->codigo_costo_orden()){
        $model->setScenario('SCE_'.$model->codigo_costo_orden());
    }else{
        $model->setScenario('SCE_'.$model->codigo_costo_directo());
    }
      $model->tipo=$tipo;
     }
        
        $model->comprobante_id=$id;
       $datos=[];
        if(h::request()->isPost){ 
            //ECHO "EL ESCEANRIO ES ".$model->getScenario();die();
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                //print_r(h::request()->post());
               // print_r($model->attributes);die();
               $model->save();
                
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('/cuentas/_modal_crea_calificacion', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
   }
   
   
     public function actionCreateOrden()
    {
        $model = new \frontend\modules\cc\models\CcOrden();
        $model->activo=true;
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-orden', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CcCc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateOrden($id)
    {
        $model =\frontend\modules\cc\models\CcOrden::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-orden', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
   
   public function actionIndexOrden()
    {
        $searchModel = new CcOrdenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_orden', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
     public function actionViewOrden($id)
    {
        return $this->render('view_orden', [
            'model' => \frontend\modules\cc\models\CcOrden::findOne($id),
        ]);
    }
    
    public function actionModEditaCalificacion($id){
    $this->layout = "install"; 
    $model=\frontend\modules\cc\models\CcGastos::findOne($id);
    $model->setScenario('SCE_'.$model->tipo);
       $datos=[];
        if(h::request()->isPost){ 
            //ECHO "EL ESCEANRIO ES ".$model->getScenario();die();
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                //print_r(h::request()->post());
               // print_r($model->attributes);die();
               $model->save();
                
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('/cuentas/_modal_crea_calificacion', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
   }
    
    
}
