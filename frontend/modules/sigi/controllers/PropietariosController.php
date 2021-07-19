<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiPropietarios;
use frontend\modules\sigi\models\SigiPropietariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * PropietariosController implements the CRUD actions for SigiPropietarios model.
 */
class PropietariosController extends baseController
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
     * Lists all SigiPropietarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiPropietariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiPropietarios model.
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
     * Creates a new SigiPropietarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiPropietarios();
        
        
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
     * Updates an existing SigiPropietarios model.
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
     * Deletes an existing SigiPropietarios model.
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
     * Finds the SigiPropietarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiPropietarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiPropietarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('base.labels', 'The requested page does not exist.'));
    }
    
    
     /*
     * cAMBOA EL ESTRADO DE KARDEX-DEPA 
     * A CANCELADO 
     */
    public function actionAjaxCreaUsuario($id){
      if(h::request()->isAjax){
          //var_dump('hola');die();
           h::response()->format = Response::FORMAT_JSON;
          $model=$this->findModel($id);  
          
          $obj=$model->generateUser();
          
          if(!$obj->hasErrors()){
              $model->user_id= \common\models\User::findOne(['email'=>$model->email])->id;
              $model->save();
              return ['success'=>yii::t('sta.labels','Se creó la cuenta de usuario {username}',['username'=>$obj->username])];
             
          }            
         
        return ['error'=>yii::t('sta.labels','No se pudo generar la cuenta de usuario {username}',['username'=>$obj->username]).'  '.$obj->getFirstError('username')];
      }
       
        
    }
    
   public function actionAgregaMail($id){        
         $this->layout = "install";
         
        $modelMail=New \frontend\modules\sigi\models\SigiMailsprop();
       $modelMail->propietario_id=$id;
       
       $datos=[];
        if(h::request()->isPost){
            $modelMail->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($modelMail);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $modelMail->save();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$modelMail->propietario_id];
            }
        }else{
           return $this->renderAjax('_modal_mail', [
                        'model' => $modelMail,
                        'id' => $id,
                        'gridName'=>h::request()->get('idGrilla'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
    
      public function actionEditaMail($id){        
         $this->layout = "install";
         
        $model= \frontend\modules\sigi\models\SigiMailsprop::findOne($id);
       //$modelMail->propietario_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->propietario_id];
            }
        }else{
           return $this->renderAjax('_modal_mail', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('idGrilla'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
}
