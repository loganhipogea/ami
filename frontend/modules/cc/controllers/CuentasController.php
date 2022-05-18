<?php

namespace frontend\modules\cc\controllers;

use Yii;
use frontend\modules\cc\models\CcCuentas;
use frontend\modules\cc\models\CcCuentasSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * CuentasController implements the CRUD actions for CcCuentas model.
 */
class CuentasController extends baseController
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
     * Lists all CcCuentas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcCuentasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcCuentas model.
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
     * Creates a new CcCuentas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcCuentas();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }ELSE{
           // PRINT_R($model->getErrors());DIE();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CcCuentas model.
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
     * Deletes an existing CcCuentas model.
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
     * Finds the CcCuentas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CcCuentas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcCuentas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    /*
     * Formulario para seleccionar el tipo de movimiento
     */
     public function actionCreaMov()
    {
        $model = new \frontend\modules\cc\models\CcMovimientos();
        $identidad=h::request()->get('id');
        $tipo=h::request()->get('tipo');
        
        $model->cuenta_id=$identidad;
        $model->tipo=$tipo;
        
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect([
                'view-mov', 'id' => $model->id,
                'tipo'=>$model->tipo
                                    ]);
        }ELSE{
           // PRINT_R($model->getErrors());DIE();
        }

        return $this->render('crea_movimiento', [
            'model' => $model,
        ]);
    }
    
     public function actionSelectMov()
    {
        $model = new \frontend\modules\cc\models\MovimientoForm();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post())) {
            
            return $this->redirect([
                'crea-mov', 'id' => $model->cuenta_id,
                'tipo'=>$model->tipo
                                    ]);
        }ELSE{
           // PRINT_R($model->getErrors());DIE();
        }

        return $this->render('_select_mov', [
            'model' => $model,
        ]);
    }
    
    public function actionViewMov($id)
    {
        $model= \frontend\modules\cc\models\CcMovimientos::findOne($id);
        return $this->render('view_mov', [
            'model' => $model,
        ]);
    }
    
     public function actionEditMov($id)
    {
        $model = \frontend\modules\cc\models\CcMovimientos::findOne($id);
       
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            return $this->redirect([
                'view-mov', 'id' => $model->id,
                //'tipo'=>$model->tipo
                                    ]);
        }ELSE{
           // PRINT_R($model->getErrors());DIE();
        }

        return $this->render('update_mov', [
            'model' => $model,
        ]);
    }
    
    public function actionModCreaComprobante($id){
    $this->layout = "install";
      $modelMov= \frontend\modules\cc\models\CcMovimientos::findOne($id);
       $model=New \frontend\modules\cc\models\CcCompras();
       $model->movimiento_id=$id;
       $datos=[];
        if(h::request()->isPost){            
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                //print_r(h::request()->post());
               // print_r($model->attributes);die();
               if(!$model->save()) print_r($model->getErrors()); 
                
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_comprobante', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
   }
   
     public function actionEditComprobante($id)
    {
        $model = \frontend\modules\cc\models\CcCompras::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-comprobante', 'id' => $model->id]);
        }

        return $this->render('update_comprobante', [
            'model' => $model,
        ]);
    }

}
