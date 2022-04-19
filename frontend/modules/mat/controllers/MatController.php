<?php

namespace frontend\modules\mat\controllers;

use Yii;
use common\components\SesionDoc;
use frontend\modules\mat\models\MatReq;
use frontend\modules\mat\models\MatVale;
use frontend\modules\mat\models\MatDetvale;
use frontend\modules\mat\models\MatReqSearch;
use frontend\controllers\base\baseController;
use \frontend\modules\mat\models\MatDetreq;
use \frontend\modules\mat\models\VwValeSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
USE yii\db\Query;
use common\helpers\h;
use yii\helpers\Url;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * MatController implements the CRUD actions for MatReq model.
 */
class MatController extends baseController
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
     * Lists all MatReq models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \frontend\modules\mat\models\MatVwReqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MatReq model.
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
     * Creates a new MatReq model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MatReq();
        
        
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
     * Updates an existing MatReq model.
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
     * Deletes an existing MatReq model.
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
     * Finds the MatReq model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MatReq the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MatReq::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionModAgregaMat($id){
    $this->layout = "install";
      $model=$this->findModel($id);
      $modeldet=New \frontend\modules\mat\models\MatDetreq();
       
       $modeldet->req_id=$id;
           $modeldet->activo=true;
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
           return $this->renderAjax('_modal_crea_item_req', [
                        'model' => $modeldet,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

     public function actionModEditMat($id){
    $this->layout = "install";
      $modeldet= \frontend\modules\mat\models\MatDetreq::findOne($id);
                 
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
                  return ['success'=>1,'id'=>$modeldet->id];
            }
        }else{
           return $this->renderAjax('_modal_crea_item_req', [
                        'model' => $modeldet,
                        'id' => $modeldet->id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

public function actionAjaxDesactivaItem($id){
    if(h::request()->isAjax){
      h::response()->format = \yii\web\Response::FORMAT_JSON;
       $model= \frontend\modules\mat\models\MatDetreq::findOne($id);
      if(!is_null($model)){
           $model->desactiva();
          return ['success'=>yii::t('app','Se anuló el item')];
      } 
    }
    
   }

   
   
     public function actionCreaVale()
    {
        $model = new MatVale();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view-vale', 'id' => $model->id]);
        }

        return $this->render('create_vale', [
            'model' => $model,
        ]);
    }

     public function actionUpdateVale($id)
    {
        $model = MatVale::findOne($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update_vale', [
            'model' => $model,
        ]);
    }
    
   
     public function actionIndexVale()
    {
        $searchModel = new VwValeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index_vale', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionModAgregaMatVale($id){
    $this->layout = "install";
      $model= MatVale::findOne($id);
      $modeldet=New MatDetvale();
       
       $modeldet->vale_id=$id;
           
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
           return $this->renderAjax('_modal_crea_item_vale', [
                        'model' => $modeldet,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
   

 public function actionModEditMatVale($id){
    $this->layout = "install";
      $modeldet= \frontend\modules\mat\models\MatDetvale::findOne($id);
                 
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
           return $this->renderAjax('_modal_crea_item_vale', [
                        'model' => $modeldet,
                        'id' => $modeldet->id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
     public function actionViewVale($id)
    {
        return $this->render('view_vale', [
            'model' => MatVale::findOne($id),
        ]);
    }
    
    
    public function actionIndexStock(){
        
        return $this->render('view_vale', [
            'model' => MatVale::findOne($id),
        ]);
    }
    
    public function  actionAjaxGuardaIdReqSesion($id){
          if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                if(!is_null($model=MatDetreq::findOne($id))){
                    if($model->activo){
                         $ses=new \common\components\SesionDoc();
                         $ses->inserta(MatDetreq::instance(), $id);
                    }                   
                  }   
                return ['success'=>yii::t('sta.errors','Se agrego el material')];
            }         
         
       }
    
    public function  actionAjaxBorraIdReqSesion($id){
        if(!is_null($model=MatDetreq::findOne($id))){
            $ses=new \common\components\SesionDoc();
            $ses->elimina(MatDetreq::className(), $id);
         }        
    }
    
    /*
     * Esta ation rellena el vale de entrada 
     * o salida con items del detalle requisicion
     */
   public function actionAjaxRellenaIdsFromReq($id){
       $ses=SesionDoc::instance();
       
       foreach($ses->valores(MatDetreq::instance()) as $key=>$iddet){
           if(!is_null($detreq=MatDetreq::findOne($iddet)) && //Si existe el id del detalle de la req
                !MatDetvale::find()->andWhere(['vale_id'=>$id,'detreq_id'=>$iddet])->exists() //Si NO existe en este vale
               ){
                    $model= MatDetvale::instance();
                    $model->setAttributes([
                    'vale_id'=>$id,
                        'item'=>$detreq->item,
                         'cant'=>$detreq->cant,
                        'um'=>$detreq->um,
                         'codart'=>$detreq->codart,
                        ]);
           }
           
       }
   }
  public function actionAjaxAprobarVale($id){
       if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                if(!is_null($model= MatVale::findOne($id))){
                    if($model->isCreado()){
                        $model->Aprobar();
                    }else{
                        return ['error'=>yii::t('sta.errors','No tiene el status adecuado')];
                    }                   
                  }   
                return ['success'=>yii::t('sta.errors','Se aprobó el vale')];
            }    
  }
  
  public function actionAjaxAnularVale($id){
      
  }
}
