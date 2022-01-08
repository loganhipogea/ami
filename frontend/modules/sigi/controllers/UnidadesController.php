<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiUnidades;
use frontend\modules\sigi\models\SigiLecturas;
use frontend\modules\sigi\models\SigiUnidadesSearch;
use frontend\modules\sigi\helpers\comboHelper;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
//use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * UnidadesController implements the CRUD actions for SigiUnidades model.
 */
class UnidadesController extends baseController
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
     * Lists all SigiUnidades models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiUnidadesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiUnidades model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update_view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new SigiUnidades model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiUnidades();

        
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
     * Updates an existing SigiUnidades model.
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
            h::session()->setFlash('success',yii::t('base.names','Se guardaron los datos'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SigiUnidades model.
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
     * Finds the SigiUnidades model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiUnidades the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiUnidades::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
    
     public function actionAgregaResidente($id){        
         $this->layout = "install";
         
        $modelunidad = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiPropietarios();
       $model->unidad_id=$id;
        $model->edificio_id=$modelunidad->edificio_id;
        $model->codepa=$modelunidad->numero;
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->unidad_id];
            }
        }else{
           return $this->renderAjax('_modal_residentes', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    public function actionEditaResidente($id){        
         $this->layout = "install";
        $model=\frontend\modules\sigi\models\SigiPropietarios::findOne($id);
        if(is_null($model))
        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_residentes', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
     public function actionAgregaMedidor($id){        
         $this->layout = "install";
         
        $modelunidad = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiSuministros();
       $model->unidad_id=$id;
       $model->edificio_id=$modelunidad->edificio_id;
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->unidad_id];
            }
        }else{
           return $this->renderAjax('_modal_medidores', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
     public function actionEditaMedidor($id){        
         $this->layout = "install";
         
        //$modelunidad = $this->findModel($id);        
       $model=\frontend\modules\sigi\models\SigiSuministros::findOne($id);
      // PRINT_R($model->lastReads(true));die();
       
       
       if(is_null($model))
        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
      
       
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_medidores', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
     public function actionAgregaHijo($id){        
         $this->layout = "install";
         
        $modelunidad = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiUnidades();
       $model->parent_id=$id;
       $model->edificio_id=$modelunidad->edificio->id;
       $model->codpro=$modelunidad->codpro;
       $model->esnuevo=$modelunidad->esnuevo;
        $model->imputable=$modelunidad->imputable;
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->parent_id];
            }
        }else{
           return $this->renderAjax('_modal_hijos', [
                        'model' => $model,
                        'modelunidad' => $modelunidad,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    
  public function actionFillApoderados(){
      
      if(h::request()->isAjax){
         // var_dump(h::request()->get('id'));die();
          $model=$this->findModel(h::request()->get('id'));
          
         $items= comboHelper::getCboApoderados(h::request()->get('id'));
         //var_dump($items);die();
         echo \yii\helpers\Html::renderSelectOptions('', $items);
      }
  } 
  
  
   public function actionAgregaLectura($id){        
         $this->layout = "install";
         
        $modelSuministro = \frontend\modules\sigi\models\SigiSuministros::findOne($id);        
       $model=New \frontend\modules\sigi\models\SigiLecturas();
       $model->unidad_id=$modelSuministro->unidad_id;
       $model->edificio_id=$modelSuministro->edificio_id;
       $model->suministro_id=$modelSuministro->id;
        $model->facturable=true;
        $model->codtipo=$modelSuministro->tipo;
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->unidad_id];
            }
        }else{
           return $this->renderAjax('_modal_lectura', [
                        'model' => $model,
                       'modelSuministro'=> $modelSuministro,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
  
   public function actionEditaLectura($id){        
         $this->layout = "install";
        $model=SigiLecturas::findOne($id);
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                
                $model->save();
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->unidad_id];
            }
        }else{
           return $this->renderAjax('_modal_lectura', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    
 public function actionLlenaAfiliados($id){
   if(h::request()->isAjax){
        h::response()->format = Response::FORMAT_JSON;
      $medidor= \frontend\modules\sigi\models\SigiSuministros::findOne($id);
    if(!is_null($medidor)){
        if(!$medidor->unidad->imputable){
            $medidor->fillDepas();
            return ['success'=>'Se agregaron unidades afiliadas'];
        }else{
            return ['error'=>'La unidad de este medidor no es imputable'];
        }
    }else{
      return ['error'=>'No existe un registro para este id'];  
    } 
   }
    
 }
 
 public function actionDesafiliar(){
     if(h::request()->isAjax){
         $id=h::request()->get('id');
         h::response()->format = Response::FORMAT_JSON; 
         $model= \frontend\modules\sigi\models\SigiSumiDepa::findOne($id);
         if(is_null($model))
          throw new NotFoundHttpException(Yii::t('sigi.labels', 'No existe el registro para este id '.$id));    
          $model->afiliado=!$model->afiliado;
          $model->save();
         return ['success'=>Yii::t('sigi.labels', 'Se desafilió esta unidad ')];
     }
 }
 
 
 public function actionDesacoplarUnidad($id){
    $model=  SigiUnidades::findOne($id);
     if(h::request()->isAjax){
           // $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
    $cat='';$message='';
    if(!is_null($model)){
        if($model->desacopla()){
            $cat='success';$message=yii::t('base.labels','Se ha desacoplado la unidad');
        }else{
           $cat='error';$message=$model->getFirstError(); 
        }
    }else{
        $cat='error';$message=yii::t('base.labels','No se encontró el id para esta unidad');
    }
        return [$cat=>$message];
    }
}

public function actionAjaxMainRecibo($id){
   if(h::request()->isAjax){
           // $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
    $propietario= \frontend\modules\sigi\models\SigiPropietarios::findOne($id);
    if(!is_null($propietario)){
        if(!$propietario->activo) return ['error'=>Yii::t('sigi.labels', 'Este propietario no está activo')];
        $propietario->updateAll(['recibo'=>'0'],['unidad_id'=>$propietario->unidad->id]);
        $propietario->updateAll(['recibo'=>'1'],['unidad_id'=>$propietario->unidad->id,'id'=>$id]);
        return ['success'=>Yii::t('sigi.labels',$propietario->nombre.'  Se estableció como titular del recibo')]; 
       }else{
       return ['error'=>Yii::t('sigi.labels', 'No se encontró el registro')]; 
    }
   }
}

  public function actionReplaceMedidor($id){        
         $this->layout = "install";         
        $modelAnt = \frontend\modules\sigi\models\SigiSuministros::findOne($id);  
        $model=New \frontend\modules\sigi\models\SigiReempmedidor();
        //$model->setScenario($model::SCENARIO_REEMPLAZO);
        $model->setAttributes([
            'suministro_id_ant'=>$modelAnt->id,
                 ]);
        //$model->codsuministro=null;
        //$model->codsuministro=null;
       
       $datos=[];
        if(h::request()->isPost){
            $model->load(h::request()->post());
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            $datos=\yii\widgets\ActiveForm::validate($model);
            if(count($datos)>0){
               return ['success'=>2,'msg'=>$datos];  
            }else{
                $transaccion=$model->getDb()->beginTransaction();
                if($model->save() && $model->resolveSuministro()){
                   $transaccion->commit(); 
                }else{
                    ECHO "NO "; DIE();
                   $transaccion->rollBack(); 
                   return ['success'=>2,'msg'=>'error']; 
                }
                //yii::error();
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_modal_reemplazo_medidor', [
                        'model' => $model,
               'modelAnt' => $modelAnt,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }

public function actionAcoplarUnidad($id){
    if(h::request()->isAjax){
    $idHija=h::request()->get('idhija',null);
    if(is_null($idHija)){
        $cat='error';$message=yii::t('base.labels','No pasó el id para la unidad hija a acoplar');
        return [$cat=>$message];
    }
    if(is_null(SigiUnidades::findOne($idHija+0))){
        $cat='error';$message=yii::t('base.labels','No se encontró el id para la unidad hija a acoplar');
        return [$cat=>$message];
    }
     $model=  SigiUnidades::findOne($id); 
             h::response()->format = \yii\web\Response::FORMAT_JSON;
    $cat='';$message='';
    if(!is_null($model)){
        $modelHija=$model->acopla($idHija);
        // YII::ERROR( 'errores');
        //YII::ERROR( $modelHija->getErrors());
        if(!$modelHija->hasErrors()){
            //YII::ERROR( 'no tiene errores');
            $cat='success';$message=yii::t('base.labels','Se ha acoplado la unidad');
        }else{
             //YII::ERROR( 'Si  tiene errores');
           $cat='error';$message=$modelHija->getFirstError(); 
            //YII::ERROR( 'El primer error es ');
           //YII::ERROR( $modelHija->getFirstError());
        }
    }else{
        $cat='error';$message=yii::t('base.labels','No se encontró el id para esta unidad');
    }
        return [$cat=>$message];
    }
}
 
}
