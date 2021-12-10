<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\Edificios;
use frontend\modules\sigi\models\EdificiosSearch;
use frontend\modules\sigi\models\SigiUnidades;
use frontend\modules\sigi\models\SigiCargosgrupoedificio as Grupos;
use frontend\modules\sigi\models\SigiBenegrupoedificio as Benes;
use frontend\modules\sigi\models\SigiCargosedificio as GrupoDetalle;
use frontend\modules\sigi\models\SigiCargosedificioSearch;
use frontend\modules\sigi\models\SigiSuministrosSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use common\helpers\timeHelper;

use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * EdificiosController implements the CRUD actions for Edificios model.
 */
class EdificiosController extends baseController
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
     * Lists all Edificios models.
     * @return mixed
     */
    public function actionIndex()
    {
       //$model=Edificios::findOne(4)->generateUsers();
      // die();
        /*$model= \frontend\modules\sigi\models\SigiFacturacion::findOne(50);
        $model->providerFaltaLecturas('101');
        var_dump($model->isCompleteReadsSuministros('101'));
        var_dump($model->providerFaltaLecturas('101')->getCount());
        die();
        $modelo=new \frontend\modules\sigi\models\SigiLecturas();
        $modelo->setScenario($modelo::SCENARIO_IMPORTACION);
        $modelo->setAttributes([
            'codepa'=>'204',
            'mes'=>10,
            'flectura'=>'13/10/2019',
            'lectura'=>600,
            'anio'=>'2019',
            'codedificio'=>'PRUEBA',
            'codtipo'=>'101',
        ]);*/
       /* var_dump($modelo->medidor()->lastRead('16/12/2019'));
        echo "<br><br><br>";
        var_dump($modelo->medidor()->nextRead('16/12/2019'));
        echo "<br><br><br>";
        die();
        var_dump($modelo::SwichtFormatDate('15/08/2019', 'date',false),$modelo->medidor()->lastRead());die();
        $modelo->validate();
        print_r($modelo->getErrors());die();
       /* $plantilla=\common\helpers\h::settings()->get('general','formatoDNI');
        $plantilla='[0-9]{8}';
        var_dump($plantilla,preg_match('10201403',$plantilla));die();*/
        
        /*$MODELI=\frontend\modules\sigi\models\SigiCargosgrupoedificio::findOne(7);
        VAR_DUMP($MODELI->hasChilds());DIE();
        */
        
        $searchModel = new EdificiosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Edificios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
         $model = $this->findModel($id);
         //var_dump($model->hasApoderados());die();
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

         $searchModel = new \frontend\modules\sigi\models\SigiUnidadesSearch();
         $dataProvider = $searchModel->searchByEdificio($model->id,Yii::$app->request->queryParams);

        
        return $this->render('update_view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }

    /**
     * Creates a new Edificios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Edificios();
        
        
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
     * Updates an existing Edificios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
      //Edificios::findOne(8)->refreshPorcentaje();
        //die();
        $model = $this->findModel($id);
         //var_dump($model->hasApoderados());die();
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

         $searchModel = new \frontend\modules\sigi\models\SigiUnidadesSearch();
         $dataProvider = $searchModel->searchByEdificio($model->id,Yii::$app->request->queryParams);

        
        return $this->render('update', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }

    /**
     * Deletes an existing Edificios model.
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
     * Finds the Edificios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Edificios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Edificios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
    
     public function actionAgregaApoderado($id){        
         $this->layout = "install";
         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiApoderados();
       $model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_apoderado', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
    
    public function actionEditaApoderado($id){        
         $this->layout = "install";
         
            
       $model=\frontend\modules\sigi\models\SigiApoderados::findOne($id);
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
                //$model->assignStudentsByRandom();
                  return ['success'=>1,'id'=>$model->id];
            }
        }else{
           return $this->renderAjax('_apoderado', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
     public function actionAgregaUnidad($id){        
         $this->layout = "install";
         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiUnidades();
       $model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_unidad', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
    
    public function actionAgregaDocu($id){        
         $this->layout = "install";
         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiEdificiodocus();
       $model->edificio_id=$id;
       $model->finicio= $model::currentDateInFormat();
       $model->ftermino=$model::currentDateInFormat(false,60*60*24*60); //Dos meses
      
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_documento', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
     public function actionEditaDocu($id){        
         $this->layout = "install";
         
        //$modeledificio = $this->findModel($id);        
       $model=\frontend\modules\sigi\models\SigiEdificiodocus::findOne($id);
       //$model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_documento', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
    
     public function actionEditaCuenta($id){        
         $this->layout = "install";
         $model= \frontend\modules\sigi\models\SigiCuentas::findOne($id);
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_cuenta', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
    
     public function actionAgregaCuenta($id){        
         $this->layout = "install";
         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiCuentas();
       $model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_cuenta', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }
 public function actionAgregaGrupo($id){        
         $this->layout = "install";
         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiCargosgrupoedificio();
       $model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_grupocargo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
   
    public function actionEditaGrupo($id){        
         $this->layout = "install";
         
        //$modeledificio = $this->findModel($id);        
       $model=\frontend\modules\sigi\models\SigiCargosgrupoedificio::findOne($id);
       
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
           return $this->renderAjax('_modal_grupocargo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
    
    /*CARGA LOS CONCEPTOS PAR AUN EDIFICIO DETERMINADO*/
    
  public function actionCargaConceptos($id){
      
   $model = $this->findModel($id);        
        $searchModel = new SigiCargosedificioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('cargaConceptos', [
            'model'=>$model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id'=>$id,
        ]); 
  }  
  

public function actionAgregaConcepto($id){
    $this->layout = "install";
         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiCargosedificio();
       $model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_concepto', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
}  

public function actionEditaConceptoTree($id){
    $this->layout = "install";
        $model=\frontend\modules\sigi\models\SigiCargosedificio::findOne($id);
       if(is_null($model)){
           throw new NotFoundHttpException(Yii::t('sigi.labels', 'Esta dirección no existe'));
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_concepto_tree', [
                        'model' => $model,
                        'id' => $model->grupo_id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

public function actionTree(){
   //echo \yii\helpers\Json::encode(Edificios::treeBase());die();
     return $this->render('_arbol',['arr_arbol'=>Edificios::treeBase()]);
    
    
}

public function  actionFillGrupos(){
    
    $edificio_id=h::request()->get('identidad');
    $datos=Grupos::find()->where(['edificio_id'=>$edificio_id])->asArray()->all();
    $ramas=[];
    /*return[
           ['key'=>$key.'_456', 'title'=>'Departamento 1'],
            ['key'=>$key.'_457', 'title'=>'Departamento 2','lazy'=>true],
         ];*/
    foreach($datos as $fila){
        $ramas[]=[
            'icon'=>'fa fa-money',
            'key'=>'_'.$edificio_id.'_grupo', 
            'title'=>$fila['descripcion'].
                     \yii\helpers\Html::a(   '<i style="color:#d633b3;"><span class="fa fa-plus-circle"></span></i>', 
                    \yii\helpers\Url::to(['/sigi/edificios/agrega-concepto-tree','id'=>$fila['id'],'gridName'=>'grilla-cuentas','idModal'=>'buscarvalor']),
                        [
                            'class'=>"botonAbre",
                            'title' => yii::t('sta.labels','Agregar Colector'),
                        ]
                    ),
            'lazy'=>true,
            'tooltip'=>'fill-grupos-detalle_'.$fila['id'],
        ];
    }
     h::response()->format = \yii\web\Response::FORMAT_JSON;
    return $ramas;
}


public function  actionFillGruposDetalle(){
    
    $grupo_id=h::request()->get('identidad');
    $datos=GrupoDetalle::find()->where(['grupo_id'=>$grupo_id])->all();
    $ramas=[];
    /*return[
           ['key'=>$key.'_456', 'title'=>'Departamento 1'],
            ['key'=>$key.'_457', 'title'=>'Departamento 2','lazy'=>true],
         ];*/
    foreach($datos as $fila){
        $ramas[]=[
            'icon'=>'fa fa-money',
            'key'=>'_'.$grupo_id.'_grupodetalle', 
            'title'=>$fila->cargo->descargo.
                     \yii\helpers\Html::a(   '<i style="color:#6f9e30;"><span class="fa fa-plus-circle"></span></i>', 
                    \yii\helpers\Url::to(['/sigi/edificios/agrega-partida-tree','id'=>$fila->id,'gridName'=>'grilla-cuentas','idModal'=>'buscarvalor']),
                        [
                            'class'=>"botonAbre",
                            'title' => yii::t('sta.labels','Agregar Colector'),
                        ]
                    ),
            //'lazy'=>true,
           // 'tooltip'=>'fill-grupos-cargo_'.$fila['id'],
        ];
    }
     h::response()->format = \yii\web\Response::FORMAT_JSON;
    return $ramas;
}

/*
 * Esta accion para agregar un concepto desde un arbol
 * id: id deñl grupo coelctor del edificio, ojo NO DEL EDIFICIO 
 */

public function actionAgregaConceptoTree($id){
    $this->layout = "install";
        $modelGrupo = Grupos::findOne($id);  
       if(is_null($modelGrupo)){
           throw new NotFoundHttpException(Yii::t('sigi.labels', 'Esta dirección no existe'));
       }
       $model=New \frontend\modules\sigi\models\SigiCargosedificio();
       $model->edificio_id=$modelGrupo->edificio->id;
       $model->grupo_id=$modelGrupo->id;       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_concepto_tree', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

public function actionPropietarios(){
    //$model= \frontend\modules\import\models\ImportCargamasivadet::findOne(72);
    //var_dump($model->esclave);die();
    $searchModel = new \frontend\modules\sigi\models\SigiPropietariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('propietarios', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
}


public function actionSuministros(){
   $searchModel = new SigiSuministrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('suministros', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
}

public function actionVerificarDatos($id){
    $this->layout = "install";
        
       $model=$this->findModel($id);   
      $model->verifyIsFacturable();
           return $this->renderAjax('_modal_verificar_datos', [
                        'model' => $model,
                        
            ]);  
         
}

public function actionLecturas($id){
    
   $model= \frontend\modules\sigi\models\SigiSuministros::findOne($id);
$searchModel = new \frontend\modules\sigi\models\SigiLecturasSearch();
$dataProvider = $searchModel->searchBySuministro($id,Yii::$app->request->queryParams);

     return  $this->render('/edificios/suministros/_form_suministro',
             ['model'=>$model,
               'dataProvider' =>$dataProvider , 
               'searchModel' =>$searchModel , 
                 ]);
    
}

public function actionGenerateUsuarios($id){
   if(h::request()->isAjax){
     h::response()->format = \yii\web\Response::FORMAT_JSON;
    $model=$this->findModel($id);
    $model->generateUsers();
    return ['success'=>yii::t('sta.errors','Se han generado los usuarios para este edificio')];
   }
     
    
}

public function actionAjaxShowUnidad(){
     if(h::request()->isAjax){
        $id=h::request()->post('expandRowKey');
       // var_dump($id);die();
         //h::response()->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax("/unidades/_detail_unit",['id'=>$id]);
       
            }
}


public function actionReplicaPresupuesto($id){
    if(h::request()->isAjax){
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                $model= $this->findModel($id);
                $model->replicaPresupuesto();
      return ['success'=>yii::t('sigi.labels','Se han creado las partidas')];
    }
}


 public function actionAgregaUser($id){        
         $this->layout = "install";         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiUserEdificios();
       $model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_usuario', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
       
       
    }


 public function actionAgregaBene($id){        
         $this->layout = "install";
         
        $modeledificio = $this->findModel($id);        
       $model=New \frontend\modules\sigi\models\SigiBenegrupoedificio();
       $model->edificio_id=$id;
       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_grupocargo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
public function actionAgregaBeneTree($id){
    $this->layout = "install";
        $modelGrupo = Benes::findOne($id);  
       if(is_null($modelGrupo)){
           throw new NotFoundHttpException(Yii::t('sigi.labels', 'Esta dirección no existe'));
       }
       $model=New \frontend\modules\sigi\models\SigiCargosedificio();
       $model->edificio_id=$modelGrupo->edificio->id;
       $model->grupo_id=$modelGrupo->id;       
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_bene_tree', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}

   public function actionEditaBene($id){        
         $this->layout = "install";
         
        //$modeledificio = $this->findModel($id);        
       $model= \frontend\modules\sigi\models\SigiCargosedificio::findOne($id);
       
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
           return $this->renderAjax('_modal_grupocargo', [
                        'model' => $model,
                        'id' => $id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        }
    }
public function actionEditaBeneTree($id){
    $this->layout = "install";
        $model= \frontend\modules\sigi\models\SigiBeneficios::findOne($id);
       if(is_null($model)){
           throw new NotFoundHttpException(Yii::t('sigi.labels', 'Esta dirección no existe'));
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
                  return ['success'=>1,'id'=>$model->edificio_id];
            }
        }else{
           return $this->renderAjax('_modal_bene_tree', [
                        'model' => $model,
                        'id' => $model->grupo_id,
                        'gridName'=>h::request()->get('gridName'),
                        'idModal'=>h::request()->get('idModal'),
                        //'cantidadLibres'=>$cantidadLibres,
          
            ]);  
        } 
}
}
