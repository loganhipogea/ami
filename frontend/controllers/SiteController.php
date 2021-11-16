<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
USE common\helpers\h;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use mdm\admin\components\UserStatus;
use mdm\admin\models\searchs\User as UserSearch;
use yii\helpers\Url;
/**
 * Site controller
 */
class SiteController extends \frontend\controllers\base\baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()    {   
       
        // $this->layout="install";       
      
        $urlBackend=str_replace('frontend','backend',yii::$app->urlManager->baseUrl);
        //if(yii::$app->user->isGuest){            
            if(\backend\components\Installer::readEnv('APP_INSTALLED')=='false'){
                          
                $this->redirect($urlBackend);             
            }else{
                
                if(yii::$app->user->isGuest){
                    $this->layout="plataforma"; 
                   return $this->render('plataforma/inicio');
                   // echo "holsa"; die();
                  return  $this->redirect(['site/login']);
                    
                }else{
                     //$this->redirect(Url::toRoute([Yii::$app->user->resolveUrlAfterLogin()]));
                      $profile=h::user()->profile;
                    $url= $profile->url;
                       $tipo=$profile->tipo;
           //yii::error(' tipo '.$tipo);
           // yii::error(' url '.$url);
           //yii::error(' tipo '.$tipo);
            if(empty($url)){
              //yii::error(' url empty sacando de settings ');   
              $url=h::gsetting('general','url.profile.'.$tipo);   
             // yii::error(' url  '.$url); 
            }
              //yii::error('LA URL ES  '.$url);                   
           if(!empty($url))
             $this->redirect(Url::to([$url]));
                      
                     //return h::user()->resolveUrlAfterLogin();
                     return $this->render('index');
                }
               
              // $this->redirect(\Yii::$app->urlManager->home);
            }
       // }else{     
          
         
           
        //}
       
        
    }
    
    

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
    
        $this->layout="install";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
 //Yii::info(" paracopmrobar   ", __METHOD__);  
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //$this->redirect(['/sta/programas']);
            //echo Url::to(Yii::$app->user->resolveUrlAfterLogin());die();
            //
            //echo Yii::$app->user->resolveUrlAfterLogin(); die();
            $this->redirect(Url::toRoute([Yii::$app->user->resolveUrlAfterLogin()]));
                 //$this->redirect(['index']); 
            //var_dump(Yii::$app->request->referrer);die();
              //return $this->redirect(is_null(Url::previous('intentona'))?Yii::$app->homeUrl:Url::previous('intentona'));
	// $this->redirect(['sta/default/view-profile','iduser'=>h::userId()]);           // return $this->goBack();
        } else {
          
            $model->password = '';
   
            return $this->render('loginSite', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
       $this->layout="install";
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                /*Agregar el rol basico*/
                
                
                
                
               if($user->status== UserStatus::INACTIVE){
                  return $this->render('waitsignup', [
                    'model' => $model,
                     ]);
                   
               }else{
                   if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                         
               }
                
                
            }
        }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

   

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout="install";
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', yii::t('base.actions','Nueva contrasena grabada.'));

            return $this->goHome();
        }
       
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionProfile(){
        
       // echo \common\helpers\FileHelper::getUrlImageUserGuest();die();
     /* if(h::app()->hasModule('sta')){
          $this->redirect(\yii\helpers\Url::toRoute('/sta/default/profile'));
      }*/
        $model =Yii::$app->user->getProfile() ;
        
        $identidad=Yii::$app->user->identity;
        $identidad->setScenario($identidad::SCENARIO_MAIL);
       // var_dump($model);die();
        if ($identidad->load(Yii::$app->request->post()) && $identidad->save() &&                
                $model->load(Yii::$app->request->post()) && $model->save()) {
           // var_dump($model->getErrors()   );die();
            yii::$app->session->setFlash('success','grabo');
            return $this->redirect(['profile', 'id' => $model->user_id]);
        }else{
           // var_dump($model->getErrors()   );die();
        }

        return $this->render('profile', [
            'identidad'=>$identidad,
            'model' => $model,
        ]);
    }
    
    /*
     * Visualiza otros perfiles 
     */
     public function actionViewProfile($iduser){
         $newIdentity=h::user()->identity->findOne($iduser);
      if(is_null($newIdentity))
          throw new BadRequestHttpException(yii::t('base.errors','User not found with id '.$iduser));  
           //echo $newIdentity->id;die();
     // h::user()->switchIdentity($newIdentity);
        $profile =$newIdentity->getProfile($iduser);
        //echo $model->id;die();
        return $this->render('profileother', [
            'profile' => $profile,
            'model'=>$newIdentity,
        ]);
    }
    
     public function actionAddfavorite(){
         $this->layout="install";
        $url=Yii::$app->request->referrer;  
        
        if(!is_null($url)){
            $url=str_replace(\yii\helpers\Url::home(true),'',$url);
           
            $model= new \common\models\Userfavoritos();
            $model->setAttributes([
                            'url'=>$url,
                             'user_id'=>h::userId(),
                                ]);        
          if ($model->load(Yii::$app->request->post()) && $model->save()) {           
           return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
                }        
        return $this->render('favorites', [
            'model' => $model,
        ]);
        }else{
            return;
        }
         
    }
    
    
    public function actionClearCache(){
       
       $datos=[];
       if(h::request()->isAjax){           
              h::settings()->invalidateCache();
              \common\helpers\FileHelper::clearTempWeb();
              //\console\components\Command::execute('cache/flush-all', ['interactive' => false]);
              //\console\components\Command::execute('cache/flush-schema', ['interactive' => false]);
           $datos['success']=yii::t('base.actions','
Datos de caché de configuración se han actualizado');
           
           h::response()->format = \yii\web\Response::FORMAT_JSON;
           
           
           
           return $datos;
        }
    }
    
    
    public function actionRequestPasswordReset()
    {
        $this->layout="install";
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            try{
                set_time_limit(300); // 5 minutes   
                $model->sendEmail();
                Yii::$app->getSession()->setFlash('success',yii::t('base.actions','Revisa tu correo para ver las instrucciones.'));
                return $this->goHome();
            } catch (\Swift_TransportException $Ste) { 
                //echo "intenado"; die();
                Yii::$app->getSession()->setFlash('error',yii::t('base.errors', 'Sorry, we are unable to reset password for email provided.'.$Ste->getMessage()));
           }
            
           
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
    }
    
    public function actionManageUsers(){
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('users', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
    
    /*
     * Esta funcion es simlar a sign-UP
     * solo que la usa el daminsitrador de
     * de la pagina o un usuario con toles para
     * manejar RBAC
     */
       public function actionCreateUser()
    {
      // $this->layout="install";
        $model = new SignupForm();
        $model->setScenario('createx');
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {   
                 yii::$app->session->
               setFlash('success',
            yii::t('base.actions','The user has been created'));
		
                  $this->redirect('manage-users');
            }
        }
        

        return $this->render('createuser', [
            'model' => $model,
        ]);
    }
public function actionRutas(){
    $model=new \frontend\modules\sigi\models\SigiFacturacion();
    $model->setScenario($model::SCE_BATCH);
   $model->setAttributes([
    'id' => null,
    'edificio_id' => '16',
    'mes' => '7',
    'ejercicio' => '2021',
    'fecha' => '09/07/2021',
    'descripcion' => null,
    'detalles' => null,
    'fvencimiento' => null,
    'reporte_id' => null,
    'detalleinterno' => null,
    'unidad_id' => null,
    'estado' => null,
    'historico' => null,
]);
  var_dump($model->save(),$model->getErrors());
  DIE();
    
    
    
    $expresion=New \yii\db\Expression('a.lectura-a.delta as lanterior');

    echo (new \yii\db\Query())         
    ->select([
      'a.kardex_id', 'a.dias','a.resumido','a.grupocobranza','a.nuevoprop','a.codmon',
      'a.id',$expresion,'a.consumototal','a.numerorecibo',
      'a.montototal','a.participacion as particmed','a.codsuministro','a.aacc','a.delta',
      'a.lectura','a.cuentaspor_id','a.edificio_id','a.unidad_id','a.colector_id',
       'a.grupo_id','a.monto','a.igv','a.grupounidad','a.grupofacturacion','a.facturacion_id',
        'a.mes','a.anio','a.identidad','a.unidades',
        'b.fecha','b.fvencimiento','b.descripcion','b.detalles',
        'c.nombre as nombreedificio','c.codigo','c.direccion',
        'd.numero','d.nombre','d.area','d.participacion',
        'f.descargo','f.codcargo',
        'g.codgrupo','g.descripcion as desgrupo',
        'h.numero as numerodepa','h.nombre as nombredepa','h.area as areadepa',
        'h.participacion as participaciondepa','mx.simbolo'
         ])
    ->from(['a'=>'{{%sigi_detfacturacion}}'])->
     innerJoin('{{%sigi_facturacion}} b', 'a.facturacion_id=b.id')->
     innerJoin('{{%sigi_edificios}} c', 'c.id=b.edificio_id')->  
      innerJoin('{{%sigi_unidades}} d', 'd.id=a.grupounidad_id')->   
      innerJoin('{{%sigi_unidades}} h', 'h.id=a.unidad_id')->
      innerJoin('{{%sigi_cargosedificio}} e', 'e.id=a.colector_id')-> 
       innerJoin('{{%sigi_cargos}} f', 'e.cargo_id=f.id')->   
        innerJoin('{{%sigi_cargosgrupoedificio}} g', 'a.grupo_id=g.id')->
         innerJoin('{{%monedas}} mx', 'mx.codmon=a.codmon')->createCommand()->rawSql;
    die();
    
    
    
    
    
    $model=new \frontend\modules\sigi\models\SigiKardexdepa();
    $model->setAttributes([
    'id' => null,
    'facturacion_id' => null,
    'operacion_id' => null,
    'edificio_id' => '22',
    'unidad_id' => null,
    'mes' => '2',
    'fecha' => '15/02/2020',
    'anio' => '2020',
    'codmon' => null,
    'numerorecibo' => null,
    'monto' => '',
    'igv' => null,
    'detalles' => null,
    'reporte_id' => null,
    'noperacion' => null,
    'banco_id' => null,
    'cancelado' => null,
    'enviado' => null,
    'aprobado' => null,
]);
    $model->setScenario($model::SCE_BATCH);
    var_dump($model->validate());
    die();
    
   $MODEL= \frontend\modules\sigi\models\SigiKardexdepa::findOne(1080);
   //$MODEL->edificio_id=589;
   
   VAR_DUMP($MODEL->save());
   VAR_DUMP($MODEL->getFirstError());
    die();
   //\frontend\modules\sigi\models\SigiKardexdepa::findOne(7092)->deleteAllAttachments();die();
    //echo \frontend\modules\sigi\models\SigiKardexdepa::findOne(7092)->files[0]->path; die();
    \frontend\modules\sigi\models\SigiFacturacion::findOne(111)->recibo(7092,true);die();
    
    //$kardex->files[0]->path
    
     $pdf=\frontend\modules\report\Module::getPdf(['format'=>'A4-L']);
     $pdf->WriteHTML("<div style ='position:absolute;  left:148px;  top:105px;  font-size:10;  font-family:cour;  color:#000;'>POSICION 148,105</div>");
                $pdf->output(/*$ruta, \Mpdf\Output\Destination::FILE*/);
     die();
    
    echo yii::getAlias('@temp'); die();
    
     $model=\frontend\modules\sigi\models\SigiUnidades::findOne(4357);
    
    
    
    $model=\frontend\modules\sigi\models\SigiUnidades::findOne(4357);
    //var_dump($model->getSigiPropietarios());die();
    print_r($model->mailsPropietarios());
    die();
    
    
    
    
      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];
            $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];
//$mpdf = new \common\components\MyMpdf([/*
$mpdf = \frontend\modules\report\Module::getPdf(['format'=>'A5-L']);
//$mpdf->curlAllowUnsafeSslRequests=TRUE;
$mpdf->Output();
//print_r(get_object_vars($mpdf));
die();


print_r($mpdf->fontdata);die(); 


          
          //$mpdf=new \Mpdf\Mpdf();
          //echo get_class($mpdf);die();
          /* $pdf->methods=[ 
           'SetHeader'=>[($model->tienecabecera)?$header:''], 
            'SetFooter'=>[($model->tienepie)?'{PAGENO}':''],
        ];*/
           $mpdf->simpleTables = true;
                 $mpdf->packTableData = true;
           $mpdf->showImageErrors = true;
           $mpdf->curlAllowUnsafeSslRequests = true; //Permite imagenes de url externas
        
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    $tiempo= microtime(true);
    set_time_limit(500);
    $tiempomaximo=ini_get('max_execution_time');
     echo $tiempo.'<br>';
      echo 'El tiempo maximo '.$tiempomaximo.'  Segundos<br>';
    sleep(305);
   $tiempo2= microtime(true);
   $diferencia=$tiempo2-$tiempo;
   if($diferencia < $tiempomaximo){
      echo " Se uso  " .$diferencia." Segundos ";
   }else{
      echo " Se acabo el tiempo ";  
   }
    
    die();
    //ini_set();
   echo ini_get('max_execution_time'); die();
    
    
    
    \backend\components\Installer::
     createMenuSingle(['/sigi/porpagar/index-multa'=>'Infracciones'],
             'Administradores');
    
    die();
    
   echo  \frontend\modules\sigi\models\SigiDetfacturacion::findOne(66758)->unidad->propietarioRecibo()->nombre;
    echo "<br>";
     echo  \frontend\modules\sigi\models\SigiDetfacturacion::findOne(66763)->unidad->oldPropietario(\frontend\modules\sigi\models\SigiUnidades::TYP_PROPIETARIO)->nombre;
 echo "<br>";
 die();
     echo  \frontend\modules\sigi\models\SigiDetfacturacion::findOne(66763)->unidad->propietarioRecibo();
 
     
     die();
    \frontend\modules\sigi\models\SigiSuministros::findOne(2059)->fillDepas();
    \frontend\modules\sigi\models\SigiSuministros::findOne(2060)->fillDepas();
    \frontend\modules\sigi\models\SigiSuministros::findOne(2061)->fillDepas();
    \frontend\modules\sigi\models\SigiSuministros::findOne(2062)->fillDepas();
    die();
   // \frontend\modules\sigi\models\SigiSuministros::findOne(2059)->fillDepas();
    
    
    var_dump(\frontend\modules\sigi\models\SigiKardexdepa::findOne(6843)->files[1]);die();
    
    
      echo " Url::home()  :   ".Url::home()."<br>";
   echo " Url::home('https')  :   ".Url::home('https')."<br>";
   echo " Url::base()  :   ".Url::base()."<br>";
   echo " Url::to(['controlador/accion','param2'=>'uno','param2'=>'dos'],true)  :   ".Url::to(['controlador/accion','param1'=>'uno','param2'=>'dos'],true)."<br>";
   echo " Url::base(true)  :   ".Url::base(true)."<br>";
   echo " Url::base('https')  :   ".Url::base('https')."<br>";
   echo " Url::canonical()  :   ".Url::canonical()."<br>";
   echo " Url::current()  :   ".Url::current()."<br>";
   echo " Url::previous()  :   ".Url::previous()."<br>";
   echo " UrlManager::getBaseUrl()  :   ".yii::$app->urlManager->getBaseUrl()."<br>";
   echo " UrlManager::getHostInfo()  :   ".yii::$app->urlManager->getHostInfo()."<br>";
   echo " UrlManager::getScriptUrl()  :   ".yii::$app->urlManager->getScriptUrl()."<br>";
  die();
    
    
    
    var_dump(\frontend\modules\sigi\models\SigiMovimientosPre::findOne(1)); die();
    
    \frontend\modules\sigi\models\SigiUserEdificios::refreshTableByUser(1871);  
     \frontend\modules\sigi\models\SigiUserEdificios::refreshTableByUser(2092); 
      \frontend\modules\sigi\models\SigiUserEdificios::refreshTableByUser(2094); 
       \frontend\modules\sigi\models\SigiUserEdificios::refreshTableByUser(2095); 
        \frontend\modules\sigi\models\SigiUserEdificios::refreshTableByUser(2107); 
         \frontend\modules\sigi\models\SigiUserEdificios::refreshTableByUser(2104); 
         // \frontend\modules\sigi\models\SigiUserEdificios::refreshTableByUser(1871); 
          DIE();
        
    
    print_r(\frontend\modules\sigi\helpers\comboHelper::getCboKardexPagados(94));
    die();
    \frontend\modules\sigi\models\SigiFacturacion::findOne(94)->asignaIdentidad();
  die(); 
    
    
    
    
  \frontend\modules\sigi\models\SigiFacturacion::findOne(94)->recibo(2035);
  die();
    
    
    
   echo \frontend\modules\sigi\models\SigiFacturacion::findOne(94)->pathRecibos();
    die();  
    
    
    
    echo \frontend\modules\sigi\models\SigiFacturacion::findOne(91)->generaRecibos();
    die();
    
    
    
    
    
    $arr=['23.5','11.34',6,'7','11.2'];
    ECHO array_sum($arr);
    die();
    
    
   var_dump( \frontend\modules\sigi\models\SigiUnidades::findOne(3877)
           ->oldValueField('parent_id')
    );
    die();
      $carbon=\Carbon\Carbon::now();
      echo $carbon->format('Y');
      
      die();
      
      
    
    
    
    
    //echo ini_get('session.gc_maxlifetime'); die();
    $session = Yii::$app->session;
    $session->open();
    
   //$session->destroy();
    
          var_dump($session->isActive,$session->id);
          $session->close();
          die();
// abre una sesión


// cierra una sesión


// destruye todos los datos registrados por la sesión.
$session->destroy();
    
    
    
    
    yii::error('rutas');
     $rol=\frontend\modules\sigi\models\SigiFacturacion::findOne(89);
    $rol->createAutoFac();
    echo "ya  ";
    die();
    //\frontend\modules\sigi\models\Edificios::findOne(22)->unidadesImputablesPadres();die();
     $auth = Yii::$app->authManager;
     $rol=\frontend\modules\sigi\models\users\SignupForm::ROL_PROPIETARIO;
               $authorRole = $auth->getRole($rol);
       var_dump($rol,$authorRole);
               die();
    
    
    $model=\frontend\modules\report\models\Reporte::findOne(2);
    var_dump($model->files[0]->path);die();
    var_dump(date('j',strtotime('2020-08-12')));die();
    
    $campos=[
    'codepa'=>'AREA COMUN 1 PISOA',
    'mes'=>'6',
    'flectura'=>'04/06/2020',
    'lectura'=>'168.37',
    'anio'=>'2020',
    'codedificio'=>'SMART',
    'codtipo'=>'1019',
];
  $model=new \frontend\modules\sigi\models\SigiLecturas();
$model->setAttributes($campos)  ;
VAR_DUMP($model->validate(),$model->getErrors());DIE();
    
    
    
    $correos=[
        'hipogea@hotmail.com',
        'neotegnia@gmail.com',
        'caballitosietecolores@gmail.com'
        ];
     $mailer = new \common\components\Mailer();
    $message =new  \yii\swiftmailer\Message();
    $cuerpo="<b>Buenas tardes, estamos trabajando para mejorar el servicio. Este es un test de correo, por favor no responder, disculpe las molestias</b>";
   // var_dump($mailer->optionsTransport[0]);die();
   $message->setSubject('Test de correo')
           ->setFrom(['neotegnia@gmail.com'=>'Correo'])
         ->setTo($correos)->SetHtmlBody($cuerpo);
 // $resultado=$mailer->sendSafe($message);
   $resultado=$mailer->send($message);
    var_dump($resultado);
    die();
    
   
   
    
    $this->layout="install";
   return $this->render('pruebazoom');
    
    $modeli=\frontend\modules\sta\models\Rangos::findOne(48);
    var_dump($modeli->talleres);die();
   /* $model=New \frontend\modules\sta\models\Citas();
    $model->fechaprog='22/03/2020 13:50:00';
    $model->talleres_id=50;
    
    var_dump($model->isInJourney(),$model->getErrors());
    die();*/
    
    
    /*$carbon=New \Carbon\Carbon();
    $carbon=$carbon->addHours(5)->addMinutes(45);
    var_dump($carbon,$carbon->parse('09:30'));die();*/
    //\frontend\modules\sta\staModule::notificaMailCitasProximas();
    //die();
   /* $fecha1='2020-02-26 07:00:00';  
    $fecha2='2020-04-15 00:45:13';
    ECHO $fecha1."<BR>";
    ECHO $fecha2."<BR>";
    var_dump(\common\helpers\timeHelper::IsFormatMysqlDateTime($fecha1),
            \common\helpers\timeHelper::IsFormatMysqlDateTime($fecha2)
            );
    die();
    
    */
   echo " Url::home()  :   ".Url::home()."<br>";
   echo " Url::home('https')  :   ".Url::home('https')."<br>";
   echo " Url::base()  :   ".Url::base()."<br>";
   echo " Url::to(['controlador/accion','param2'=>'uno','param2'=>'dos'],true)  :   ".Url::to(['controlador/accion','param1'=>'uno','param2'=>'dos'],true)."<br>";
   echo " Url::base(true)  :   ".Url::base(true)."<br>";
   echo " Url::base('https')  :   ".Url::base('https')."<br>";
   echo " Url::canonical()  :   ".Url::canonical()."<br>";
   echo " Url::current()  :   ".Url::current()."<br>";
   echo " Url::previous()  :   ".Url::previous()."<br>";
   echo " UrlManager::getBaseUrl()  :   ".yii::$app->urlManager->getBaseUrl()."<br>";
   echo " UrlManager::getHostInfo()  :   ".yii::$app->urlManager->getHostInfo()."<br>";
   echo " UrlManager::getScriptUrl()  :   ".yii::$app->urlManager->getScriptUrl()."<br>";
   //yii::$app->urlManager->setHostInfo('');
   //echo " Url::base()  :   ".Url::base()."<br>";
   //echo " UrlManager::setHostInfo()   :   ".yii::$app->urlManager->setHostInfo('http://case.itekron.com/frontend/web/sta/entregas/update?id=32')."<br>";
}
public function actionCookies(){
    $cookiesRead = Yii::$app->request->cookies;
    $cookiesSend = Yii::$app->response->cookies;
    if($cookiesRead->has('token')){
         echo "Existe la cookie token y el valor es ".$cookiesRead->get('token')->value;
    }else{
         $cookiesSend->add(new \yii\web\Cookie([
    'name' => 'token',
    'value' => 'myvalor de cookie',
             ]));
         echo "no existia la cooike toke,perio ya se agrego";
    }
    // var_dump($cookies );
  
   }

  public function actionPutUrlDefault(){
     if(h::request()->isAjax){
           h::response()->format = \yii\web\Response::FORMAT_JSON;
           $cambio= h::user()->putUrlDefault(Yii::$app->request->referrer);
          if($cambio){
              return ['success'=>yii::t('sta.labels','Se estableció la ruta sin problemas')];
          }else{
              return ['error'=>yii::t('sta.labels','Hubo un error')]; 
          }
        }  
     
  }  
   
   
   /*
     * Visualiza otros perfiles 
     */
     public function actionChangePwd($iduser){
         $model=h::user()->identity;
         $newIdentity=h::user()->identity->findOne($iduser);
      if(is_null($newIdentity))
          throw new BadRequestHttpException(yii::t('base.errors','User not found with id '.$iduser));  
       
      
         if ($model->load(Yii::$app->getRequest()->post()) && $model->validate()) {
            try{
                set_time_limit(300); // 5 minutes   
                $model->sendEmail();
                Yii::$app->getSession()->setFlash('success',yii::t('base.actions','Revisa tu correo para ver las instrucciones.'));
                return $this->goHome();
            } catch (\Swift_TransportException $Ste) { 
                //echo "intenado"; die();
                Yii::$app->getSession()->setFlash('error',yii::t('base.errors', 'Sorry, we are unable to reset password for email provided.'.$Ste->getMessage()));
           }
            
           
        }

        return $this->render('requestPasswordResetToken', [
                'model' => $model,
        ]);
      
      
      
    }
  
  public function actionFaltaPagos(){
      $this->layout="install";
      return $this->render('faltadepago');
  }
  
  public function actionPruebaChat(){
  // yii::error('url telegram',__FUNcTION__);
       yii::error('en la funcion bot -telegram ');
       
       $update = json_decode(file_get_contents("php://input"), TRUE);
       //var_dump($update);die();
       $chatId = $update["message"]["chat"]["id"];
        $message = $update["message"]["text"];
        yii::error('chat id',__FUNCTION__);
         yii::error($chatId,__FUNCTION__);
         yii::error('mensaje',__FUNCTION__);
         yii::error($message,__FUNCTION__);
        
        switch($message){
         case '/start' :
              yii::error('case start ');
             $mensaje='Hola he iniciado';
             $this->sendMessage($chatId, $mensaje);
                break;
        case '/hola' :
            yii::error('case hola ');
             $mensaje='Hola tambien como estas';
            $this->sendMessage($chatId, $mensaje);
                break;
          default:
              yii::error('case default ');
             $mensaje='No entiendo habla bien';
              $this->sendMessage($chatId, $mensaje);
                break;  
          
      }
      
       //$cliente=\common\models\MediaApps::findOne(13)->client;
       //$respuesta=$cliente->sendMessage($chatId,$message);
       //var_dump($respuesta);
   }
   
   public function sendMessage($chatId, $mensaje){
       //yii::error('enviando mensaje',__FUNCTION__);
        yii::error('chat id',__FUNCTION__);
         yii::error($chatId,__FUNCTION__);
         yii::error('mensaje',__FUNCTION__);
         yii::error($mensaje,__FUNCTION__);
       yii::error('enviando mensaje');
      $url=  'https://api.telegram.org/bot1866798661:AAHFfSizi4mkrRDjydoZ0VE-xjZaK6PyBhM/sendMessage?chat_id='.$chatId.'&text='. urlencode($mensaje);
      file_get_contents($url);
   }
   
   
   public function actionPlataforma($id){
       $this->layout="plataforma"; 
       
        switch ($id) {
            case 1:
                return $this->render('plataforma/inicio');
                break;
            case 2:
                return $this->render('plataforma/nosotros');
                break;
            case 3:
                return $this->render('plataforma/clientes');
                break;
            case 4:
                return $this->render('plataforma/contacto');
                break;
            break;
       }
             
   }
   
   public function actionEnviaMailCont(){
        if(h::request()->isAjax){
           h::response()->format = \yii\web\Response::FORMAT_JSON;
                $datos=h::request()->post();
                    $mensaje=$datos['mensaje'].'  Teléfono '.$datos['telefono'];
               if(empty($datos['nombre']))return [['error'=>'Ingrese su nombre']];
               if(empty($datos['correo'])){
                   return ['error'=>'Ingrese su correo'];  
               }else{
                   $valid=New \yii\validators\EmailValidator();
                   if(!$valid->validate($datos['correo']))
                   return ['error'=>'Dirección de correo no válida'];
               }
               if(empty($datos['mensaje']))
                   return ['error'=>'Ingrese el mensaje'];  
                   
                   
            $mailer = new \common\components\Mailer();
            $message =new  \yii\swiftmailer\Message();
             $message->setSubject('Mensaje nuevo de la página web')
                 ->setFrom([$datos['correo']=>$datos['nombre']])
                ->setTo('hipogea@hotmail.com')->SetHtmlBody($mensaje);
             try{
                 $resultado=$mailer->send($message);
             } catch (\Exception $ex) {
            return ['error'=>$ex->getMessage()];
                 } 
             }
            return ['success'=>'Se envió el correo, pronto nos estaremos comunicando con Ud. Muchas Gracias.'];
        } 
  
   public function actionLoginResidente(){
   
        $model=new LoginForm();

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = \yii\web\Response::FORMAT_JSON;
                return \yii\widgets\ActiveForm::validate($model);
        }
        
         if ($model->load(Yii::$app->request->post()) && $model->login()) {
              $this->redirect(Url::toRoute(['/sigi/default/panel-residente']));
               //$this->redirect(Url::toRoute([Yii::$app->user->resolveUrlAfterLogin()]));
             } else {
          
            $model->password = '';
                    $this->layout="plataforma"; 
                   return $this->render('plataforma/inicio');
        }
    

   }     
        
}
   
   

