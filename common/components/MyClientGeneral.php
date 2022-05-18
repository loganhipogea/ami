<?php
namespace common\components;

use common\authclient\OAuth2;
//use common\authclient\OAuthToken;

use yii\helpers\Json;
use yii;
//use yii\base\InvalidConfigException;
class MyClientGeneral extends OAuth2 
{
 public $token_directo='255e64ec71ae34ae5f32eeeb645b4e578aa32db5acb86b715b85bf3a1493a139';
 public $apiBaseUrl="https://apiperu.dev/api";  

public function init(){
    
    parent::init();
   
    
}


 protected function initUserAttributes()
    {
        return $this->api('userinfo', 'GET');
    } 
    
 
 
 
 /*private function mapAttributes(MediaApps $app){
     $this->expireDuration=$this->providerMedia->duration_token;
     
     
 }*/
public function apiRuc($ruc){
    /*array(3) { ["success"]=> bool(true)
        ["data"]=> array(12) { ["direccion"]=> string(38) "AV. SANTA ANA NRO. 562 URB. LOS SAUCES" 
        ["direccion_completa"]=> string(57) "AV. SANTA ANA NRO. 562 URB. LOS SAUCES, LIMA - LIMA - ATE" 
        ["ruc"]=> string(11) "20600279832" 
        ["nombre_o_razon_social"]=> string(47) "NEOTEGNIA CONSULTORES S.A.C. - NEOTEGNIA S.A.C." 
        ["estado"]=> string(6) "ACTIVO" 
        ["condicion"]=> string(6) "HABIDO" 
        ["departamento"]=> string(4) "LIMA" 
        ["provincia"]=> string(4) "LIMA" 
        ["distrito"]=> string(3) "ATE" 
        ["ubigeo_sunat"]=> string(6) "150103" 
        ["ubigeo"]=> array(3) { [0]=> string(2) "15" [1]=> string(4) "1501" [2]=> string(6) "150103" } 
        ["es_agente_de_retencion"]=> string(2) "NO" }
        ["source"]=> string(11) "apiperu.dev" }*/
    $request=$this->httpClient->get(
             $this->apiBaseUrl.'/ruc/'.$ruc.'?api_token='.$this->token_directo,
             //'POST', 
              //Json::encode($params),
             //["Content-Type" => "application/json"]
            );
  //$this->applyAccessTokenToRequest($request,$this->getState('token'));
   $response=$request->send();
   //var_dump($response);die();
   
 if($response->isOk){
    return $response->getData();
 }else{
    return false;
 } 
}


 

public function apiDni($dni){
    /*array(3) { ["success"]=> bool(true)
        ["data"]=> array(12) { ["direccion"]=> string(38) "AV. SANTA ANA NRO. 562 URB. LOS SAUCES" 
        ["direccion_completa"]=> string(57) "AV. SANTA ANA NRO. 562 URB. LOS SAUCES, LIMA - LIMA - ATE" 
        ["ruc"]=> string(11) "20600279832" 
        ["nombre_o_razon_social"]=> string(47) "NEOTEGNIA CONSULTORES S.A.C. - NEOTEGNIA S.A.C." 
        ["estado"]=> string(6) "ACTIVO" 
        ["condicion"]=> string(6) "HABIDO" 
        ["departamento"]=> string(4) "LIMA" 
        ["provincia"]=> string(4) "LIMA" 
        ["distrito"]=> string(3) "ATE" 
        ["ubigeo_sunat"]=> string(6) "150103" 
        ["ubigeo"]=> array(3) { [0]=> string(2) "15" [1]=> string(4) "1501" [2]=> string(6) "150103" } 
        ["es_agente_de_retencion"]=> string(2) "NO" }
        ["source"]=> string(11) "apiperu.dev" }*/
    $request=$this->httpClient->get(
             $this->apiBaseUrl.'/dni/'.$dni.'?api_token='.$this->token_directo,
             //'POST', 
              //Json::encode($params),
             //["Content-Type" => "application/json"]
            );
  //$this->applyAccessTokenToRequest($request,$this->getState('token'));
   $response=$request->send();
   //var_dump($response);die();
   
 if($response->isOk){
    return $response->getData();
 }else{
    return false;
 } 
}

public function createMeet($params){
    $request=$this->httpClient->post(
             $this->apiBaseUrl.'/v1/meetings',
             //'POST', 
              Json::encode($params),
             ["Content-Type" => "application/json"]
            );
  //$this->applyAccessTokenToRequest($request,$this->getState('token'));
   $response=$request->send();
   
 if($response->isOk){
    return ['success'=>$response->getData()];
 }else{
    return ['warning'=>Json::encode($response->getData())];
 }
   }
   
  
} 


