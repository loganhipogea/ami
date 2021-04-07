<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiKardexdepa;
use frontend\modules\sigi\models\SigiKardexdepaSearch;
use frontend\modules\sigi\models\SigiMovimientosPre;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * KardexdepaController implements the CRUD actions for SigiKardexdepa model.
 */
class KardexdepaController extends baseController
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
     * Lists all SigiKardexdepa models.
     * @return mixed
     */
    public function actionIndex()
    {        
        
       // $searchModel = new \frontend\modules\sigi\models\VwSigiKardexdepaSearch();
        $searchModel = new \frontend\modules\sigi\models\VwKardexPagosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//var_dump($dataProvider );die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single SigiKardexdepa model.
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
     * Creates a new SigiKardexdepa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiKardexdepa();
        
        
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
     * Updates an existing SigiKardexdepa model.
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
     * Deletes an existing SigiKardexdepa model.
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
     * Finds the SigiKardexdepa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiKardexdepa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiKardexdepa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    /*
     * cAMBOA EL ESTRADO DE KARDEX-DEPA 
     * A CANCELADO 
     */
    public function actionAjaxCancelado($id){
      if(h::request()->isAjax){
           h::response()->format = Response::FORMAT_JSON;
          $model=$this->findModel($id);
          if($model->monto>0){            
        return ($model->cancelar())?['success'=>yii::t('sta.labels','Se confirmó la cancelación del recibo')]
                :[['error'=>yii::t('sta.labels','Hay problemas {problema}',['problema'=>$model->getFirstError()])]];
           
          }
        return ['error'=>yii::t('sta.labels','El monto no es el adecuado')];
      }
       
        
    }
    
    public function actionAjaxCreaMov($id){
       
        if(h::request()->isAjax){
            $model=$this->findModel($id);
            $valor=SigiMovimientosPre::createBasic([ 
            'kardex_id'=>$model->id,
            'edificio_id'=>$model->edificio_id,
            'cuenta_id'=>$model->edificio->cuentas[0]->id,
            'tipomov'=> \frontend\modules\sigi\models\SigiTipomov::TIPOMOV_DEFAULT,
            'glosa'=>yii::t('sigi.labels','PAGO DE CUOTA').'-'.$model->unidad->numero, 
            'monto'=>$model->montoCalculado(), 
            'activo'=>'1'            
        ]);
        }
    }
    
    
  public function actionAjaxShowPagos(){
     if(h::request()->isAjax){
        $id=h::request()->post('expandRowKey');
        var_dump(h::request()->post(),$id);die();
         //h::response()->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax("_expand_row_pagos",['id'=>$id]);
       
            }
   }  
   
   public function actionPagos()
    {
      // echo "<i style='color: blue'><span class='fa fa-user'></span>thomas ramirez espinoza</i>"; die();
       
       
       
        
        $searchModel = new \frontend\modules\sigi\models\VwKardexPagosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//var_dump($dataProvider );die();
        return $this->render('index_pagos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

}
