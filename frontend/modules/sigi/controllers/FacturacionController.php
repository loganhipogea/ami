<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiFacturacion;
use frontend\modules\sigi\models\SigiFacturacionSearch;
use frontend\modules\sigi\models\SigiCuentasporSearch;
use frontend\modules\sigi\models\VwSigiFacturecibo;
use frontend\modules\sigi\models\VwSigiFactureciboSearch;
use frontend\modules\sigi\models\VwSigiLecturasSearch;
use frontend\modules\sigi\models\SigiDetfacturacion;
use frontend\modules\sigi\models\SigiDetfacturacionSearch;
use frontend\controllers\base\baseController;
use frontend\modules\report\Module as ModuleReporte;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * FacturacionController implements the CRUD actions for SigiFacturacion model.
 */
class FacturacionController extends baseController
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
     * Lists all SigiFacturacion models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$model= \frontend\modules\sigi\models\SigiUnidades::findOne(1950);
       // print_r($model->arrayPropietarios(false));die();
        //echo date('t',$model->swichtDate('fecha',false));
        //$model->resolveRecibosPartidos();
        //die();
        
       
          /*\Yii::$app->session->open();
        $userDirPath = Yii::$app->session->id;
        echo "Primer intento<br>";
         echo $userDirPath;echo "<br>";
        \Yii::$app->session->close();
          $userDirPath = Yii::$app->session->id;
           echo "Segundo intento<br>";
        echo $userDirPath;die();
         echo "------<br><br>";*/
        $searchModel = new SigiFacturacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiFacturacion model.
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
     * Creates a new SigiFacturacion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiFacturacion();
        
        
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
     * Updates an existing SigiFacturacion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
     //echo \frontend\modules\sigi\models\SigiUnidades::findOne(704)->porcWithChilds();
      //  die();
        /* 
     //echo h::gsetting('mail','servermail');die();
          $mailer = new \common\components\Mailer();
        $message =new  \yii\swiftmailer\Message();
            $message->setSubject('Notificacion de Examen')
            ->setFrom(['jramirez@neotegnia.com'=>'JULIA RAMIREZ TENOROP'])
            ->setTo('hipogea@hotmail.com')
            ->SetHtmlBody("Buenas Tardes  ulian <br>"
                    . "La presente es para notificarle que tienes "
                    . "una examen  programado. <br> Presiona el siguiente link "
                    . "para acceder a la prueba: <br>"
                    . "    <a  href=\o\" >Presiona aquí </a>");
            
            
           
    try {
        
           $result = $mailer->send($message);
           $mensajes['success']='Se envió el correo, invitando al examen, el Alumno tiene que responder ';
            echo "exceknte r ";
    } catch (\Swift_TransportException $Ste) { 
        
         $mensajes['error']=$Ste->getMessage();
         echo "huibo un error ",$Ste->getMessage();
    }  
    
     die();   
        
      /*  
        
        
    $transport = new \Swift_SmtpTransport();
    //echo get_class($transport);die();
          $transport->setHost('mail.neotegnia.com')
            ->setPort('465')
            ->setEncryption('tls')
            ->setStreamOptions(['ssl' =>['allow_self_signed' => true,'verify_peer_name' => false, 'verify_peer' => false]] )
            ->setUsername('jramirez')
            ->setPassword('toxoplasma1');
        $mailer = new \Swift_Mailer($transport);
        $message =new  \Swift_Message();
            $message->setSubject('Test Message')
            ->setFrom(['hipogea@hotmail.com'=>'Jorge Paredes'])
            ->setTo('jramirez@neotegnia.com')
            ->setBody('Este es un test');

  
    try {
           set_time_limit(300); // 5 minutes    
        $result = $mailer->send($message);
        static::psetting('mail','servemail',$serverMail);//'mail.neotegnia.com'
          static::psetting('mail','userservermail',$userMail);//'jramirez@neotegnia.com',
          static::psetting('mail','passworduserservermail',$passwordMail);//'toxoplasma1',
           static::psetting('mail','portservermail',$portMail);// '25',*/
        
        
        
   /* } catch (\Swift_TransportException $Ste) {
      
        echo $Ste->getMessage(); die();
    }
       */ 
  /*tend\modules\sigi\models\Edificios::findOne(7);
$edificio->refreshPorcentaje();
die();*/
//$modelo=\frontend\modules\sigi\models\SigiSuministros::findOne(117);
        //var_dump($modelo->LastReadFacturable('12','2019'));DIE();
        $model = $this->findModel($id);
       /* $model->obtenerForeignClass('reporte_id');
         var_dump($model->obtenerForeignClass('reporte_id'),$model->fieldsLink(false));die();*/

        
        /*
         * La clave para saber si esta facturacion es editable 
         */
        $esEditable=$model->isEditable();
        
        
          $searchModel = new SigiCuentasporSearch();
         $dataProviderCuentasPor = $searchModel->searchByFactu($model->id); 
         
         
         
         
        /* $searchModelPartidas = new \frontend\modules\sigi\models\SigiBasePresupuestoSearch();
         $dataProviderPartidas = $searchModelPartidas->searchByEdificio($model->edificio_id,Yii::$app->request->queryParams); 
        */// $searchModelLecturas = new VwSigiTempLecturasSearch();
        //$dataProviderLecturas = $searchModelLecturas->searchByCuentasPor($model->idsToCuentasPor(),Yii::$app->request->queryParams);
         
         
          $searchModelLecturas = new \frontend\modules\sigi\models\VwSigiLecturasSearch();
         $dataProviderLecturas = $searchModelLecturas->searchByFacturacionParams($model->edificio_id,$model->mes,$model->ejercicio,Yii::$app->request->queryParams); 
         
      
         
          $dataProviderLecturasFaltan =$model->providerFaltaLecturas('101');
         if (h::request()->isAjax && $model->load(h::request()->post())) {
             
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'dataProviderCuentasPor' =>$dataProviderCuentasPor,           
            'dataProviderLecturasFaltan' =>$dataProviderLecturasFaltan,
           // 'searchModelPartidas' => $searchModelPartidas,
            'esEditable'=>$esEditable,
         //'dataProviderPartidas' => $dataProviderPartidas,
             'searchModelLecturas' =>  $searchModelLecturas,
         'dataProviderLecturas' => $dataProviderLecturas,
        ]);
    }

    /**
     * Deletes an existing SigiFacturacion model.
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
     * Finds the SigiFacturacion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SigiFacturacion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
            
    {
        if (($model = SigiFacturacion::findOne($id)) !== null) {
            return $model;
        }
        

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
   
    
    
    public function actionFacturacionMes($id){
        if (h::request()->isAjax) {
            $errores=[];
            yii::error('que pasa');
                h::response()->format = Response::FORMAT_JSON;
           $model=$this->findModel($id);
            $errores=$model->generateFacturacionMes();
           //$model->shortFactu();
            if(count($errores)>0){
               return $errores;
           }else{
               return ['success'=>'Se ha generado la facturación del mes'];
           }
       }
       
    }
    
    public function actionResetFacturacionMes($id){
        if (h::request()->isAjax) {
            //$errores=[];
                h::response()->format = Response::FORMAT_JSON;
           $model=$this->findModel($id);
           if($model->resetFacturacion()){
               return ['success'=>yii::t('sigi.labels','Se ha reinicado la facturación')];
       
              }else{
                 return ['error'=>yii::t('sigi.labels','No puede reiniciar la facturacion, porque lso datos ya participan el el proceso de cobranzas')];
        
              }
           }
       
    }
    
    public function actionCrearLecturas($id){
        if (h::request()->isAjax) {
              h::response()->format = Response::FORMAT_JSON;
           $model= \frontend\modules\sigi\models\SigiCuentaspor::findOne($id);
           if(!is_null($model)){
               $model->creaRegistroLecturasTemp();
               return ['success'=>yii::t('sigi.labels','Se ha generado la plantilla de lecturas')];
           }else{
               return ['error'=>yii::t('sigi.labels','No se ha encontrado un registro para este id')]; 
           }
            
           
       }
       
    }
    
   public function actionDetalleFacturacion($id){
      $this->findModel($id);
         $searchModel = new  VwSigiFactureciboSearch();
        $dataProvider = $searchModel->search($id,Yii::$app->request->queryParams);

        return $this->render('detalle', ['id'=>$id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
   }
   
   
   public function actionLecturas(){
      
         $searchModel = new VwSigiLecturasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       // echo $dataProvider->query->createCommand()->rawSql;die();
        return $this->render('lecturas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); 
   }
   
   /*Texto recomendacion*/
   public function actionAjaxRecomendacion($id){
       if(h::request()->isAjax){
           //$modeled=$this->findModel($id);
           $edificio=\frontend\modules\sigi\models\Edificios::findOne($id); 
         if(!is_null($edificio)){
             
             return $edificio->messageFacturacion();
             
             
         }
           
       }
   }
 
 public function actionIniciaLecturas(){
     $model=New \frontend\modules\sigi\models\SigiLecturas();
     $model->setScenario($model::SCENARIO_SESION);
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post())) {
            $session=h::session();
            $session['lecturas'] = [
                                'edificio_id' =>$model->edificio_id,
                                'anio' => $model->anio,
                                'mes' => $model->mes,
                                'facturable' => $model->facturable,
                                'flectura' => $model->flectura, 
                                'codedificio'=>$model->codedificio,
                                'tipomedidor'=>h::request()->post('codtipo'),
                                    ];
            
            return $this->redirect(['toma-lecturas']);
        }

        return $this->render('_inicio_lecturas', [
            'model' => $model,
        ]);
 }


public function actionTomaLecturas(){
     $model=New \frontend\modules\sigi\models\SigiLecturas();
     $model->setScenario($model::SCENARIO_SESION);
     $session=h::session();
     if ($session->has('lecturas')){
         //var_dump($session['lecturas']);die();
         $model->edificio_id= $session['lecturas']['edificio_id'];
        // $model->edificio_id= $session['lecturas']['edificio_id'];
         $model->anio=$session['lecturas']['anio'];
          $model->mes=$session['lecturas']['mes'];
          $model->facturable=true;
          $model->codtipo=$session['lecturas']['tipomedidor'];
          $model->flectura=$session['lecturas']['flectura'];
          $model->codedificio=$model->edificio->codigo;
          if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
       
        /*$model->load(Yii::$app->request->post());
         * 
       print_r($model->attributes);print_r(Yii::$app->request->post());die();*/
      
       
       
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            
            $session->setFlash('success', yii::t('sigi.labels','Se grabó lectura'));
            return $this->redirect(['toma-lecturas','tipomedidor'=>$session['lecturas']['tipomedidor']]);
        }else{
            
            if($model->hasErrors())
            $session->setFlash('error', yii::t('sigi.labels',$model->getFirstError()));
            //return $this->redirect(['toma-lecturas','tipomedidor'=>$session['lecturas']['tipomedidor']]);
            
        }

        return $this->render('_lectura', [
            'model' => $model,
        ]);
        
     }else{
         echo "primero establezca valores predefinidos";
     }
        
        
}

public function actionSendRecibo($id){
   if (h::request()->isAjax ) {
        h::response()->format = Response::FORMAT_JSON;
            $model= \frontend\modules\sigi\models\SigiKardexdepa::findOne($id);
            $mensajes=$model->mailRecibo();
            return $mensajes;
   }
    
}


public function actionSendMassiveRecibo($id){
   if (h::request()->isAjax ) {
        h::response()->format = Response::FORMAT_JSON;
            $model= $this->findModel($id);
           if(!is_null($model)){
               $model->sendMassiveRecibo();
               return ['success',yii::t('base.labels','Se enviaron masivamente los recibos')];
                 }            
          }     
  }
  
 
  public function actionRecibo($kardexid){
       $this->layout='blank';
       $disk=(is_null(h::request()->get('disk')))?false:true;
       
      $query=SigiDetfacturacion::find()->andWhere(['kardex_id'=>$kardexid]);
        if(!$query->exists()){
         throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested identiti bill does not exist.'));
        }else{
          $query->one()->facturacion->recibo($kardexid,$disk); 
        }
  }
  
  public function actionGeneraRecibos($id){
       $this->layout='blank';
      if (h::request()->isAjax ) {
        h::response()->format = Response::FORMAT_JSON;
     $model= $this->findModel($id);
     $model->generaRecibos();
      return ['success'=>yii::t('base.labels','Se han generado los recibos')];
              
      }
  }
  
public function actionClearRecibos($id){
    if (h::request()->isAjax ) {
        h::response()->format = Response::FORMAT_JSON;
            $model= $this->findModel($id);
           if(!is_null($model)){
               $model->purgeRecibos();
               return ['success'=>yii::t('base.labels','Se resetearon todos los recibos')];
                 }            
          }   
}
 
public function actionCompileRecibos($id){
    if (h::request()->isAjax ) {
        h::response()->format = Response::FORMAT_JSON;
            $model= $this->findModel($id);
           if(!is_null($model)){
               $model->compileRecibos();
               return ['success'=>yii::t('base.labels','Se compilaron los recibos')];
                 }            
          }   
}


public function actionDownloadPart($id){
   $parte=h::request()->get('part');
    $model=$this->findModel($id); 
    $ruta=$model->pathRecibos().'BLOQUE_'.$parte.'.pdf';
    if(!is_file($ruta))
     throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested file does not exist.')); 
   $nameFile=$model->edificio->codigo.'_'.$model->mes.$model->ejercicio.'_'.$parte.'.pdf';
  return Yii::$app->response->sendFile($ruta,$nameFile);
    
}


public function actionReciboByKardex($id){
    $this->layout='blank';
    if (h::request()->isAjax ) {
        h::response()->format = Response::FORMAT_JSON; 
            $kardex= \frontend\modules\sigi\models\SigiKardexdepa::findOne($id);
            $facturacion=$kardex->facturacion;
            if(!$facturacion->hasNextFacturacionWithDetail()){
               $facturacion->recibo($kardex->id,true);
                return ['success'=>yii::t('base.labels','Se generó el recibo para '.$kardex->unidad->nombre)];   
     
            }else{
                return ['error'=>yii::t('base.labels','Ya hay cobranzas con datos de este recibo, ya no puede regenerar')];   
      
            }
         }
}


public function actionAprobe($id){
       $model= $this->findModel($id);
      if($model->aprove()){
        /* return ['success'=>yii::t('base.labels','Se aprobó la facturación ')];   
         }else{
         return ['error'=>yii::t('base.labels','Hubo un problema '.$model->getFirstError())];   
         */ 
          h::session()->setFlash('success',yii::t('base.labels','Se aprobó la facturación '));
        }else{
           h::session()->setFlash('error',yii::t('base.labels','Hubo un problema '.$model->getFirstError()));
        }
      $this->redirect(['update','id'=>$model->id]);       
   }

public function actionUnAprobe($id){
   $model= $this->findModel($id);
      if($model->aprove(true)){
        /* return ['success'=>yii::t('base.labels','Se aprobó la facturación ')];   
         }else{
         return ['error'=>yii::t('base.labels','Hubo un problema '.$model->getFirstError())];   
         */ 
          h::session()->setFlash('success',yii::t('base.labels','Se desaprobó la facturación '));
        }else{
            if($model->hasErrors())
           h::session()->setFlash('error',yii::t('base.labels','Hubo un problema '.$model->getFirstError()));
        
            h::session()->setFlash('error',yii::t('base.labels','No se puede deshacer esta opcion, ya hay datos comprometidos'));
        }
      $this->redirect(['update','id'=>$model->id]);  
}

public function actionResumen($id){
    $model=$this->findModel($id);    
     $searchModel = new \frontend\modules\sigi\models\SigiKardexdepaSearch();
     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
   return $this->render('resumen',[
       'model'=>$model,
       'dataProvider'=>$dataProvider,
           'searchModel'=>$searchModel
           ]);   
}


 public function actionRefreshMontoKardex($id){
     if(h::request()->isAjax){
         h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=$this->findModel($id);
        $model->updateAllMontoKardex();
       return ['success'=>yii::t('base.labels','Se actualizaron los montos')];
            }
   } 

public function actionTestPdf(){
    $model=$this->findModel(111);
    $model->generaRecibos();
   // $this->recibo($kardex['kardex_id'],true);
    /*$idsKARDEX=[7091,7092,7093,7094,7095,7096];
    
     foreach($idsKARDEX as $id=>$identidad){
         $model->recibo($identidad,true); 
     }*/
    //\frontend\modules\sigi\models\SigiKardexdepa::findOne(7092)->deleteAllAttachments();die();
    //echo \frontend\modules\sigi\models\SigiKardexdepa::findOne(7092)->files[0]->path; die();
    //\frontend\modules\sigi\models\SigiFacturacion::findOne(111)->recibo(7092,true);die();
    
}

   public function actionRecuperaDocs($id){
     if(h::request()->isAjax){
         h::response()->format = \yii\web\Response::FORMAT_JSON;
        $model=$this->findModel($id);
        $ndocs=$model->rescueDocsFromEdificios();
        if($ndocs== 0){
            return ['warning'=>yii::t('base.labels','No se encontró ningún documento para anexar')];
        }else{
           return ['success'=>yii::t('base.labels','Se agregaron {numero} documentos',['numero'=>$ndocs])];
       
        }
       
            }
   } 



}
