<?php
namespace common\actions;
use common\helpers\h;
use yii\helpers\Json;
use common\helpers\ComboHelper;
USE yii\helpers\Html;
use yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ActionCombodependiente extends \yii\base\Action
{	
	public function run(){
	$valorfiltro=h::request()->post('filtro');
           $isremote=h::request()->post('isremotesource');
           $source=h::request()->post('source');
           $multiple=h::request()->post('ismultiple');
           //var_dump($multiple);die();
      if($multiple=='yes'){
            $datos=[];
          if($isremote=='yes'){ 
              foreach($source as $IdControl=>$ArrayValores){
                  $nombreModelo=array_keys($ArrayValores)[0];
                
                  $clase= new $nombreModelo;
             if($clase instanceof ComboHelper){
                 $funcion= $ArrayValores[$nombreModelo]['campofiltro'];
                $datos[$IdControl]=$clase::{$funcion}($valorfiltro);
             }else{
                  $datos[$IdControl]= ComboHelper::getCboGeneral(
                     $valorfiltro,
                     $nombreModelo,//nombre del modelo
                     $ArrayValores[$nombreModelo]['campofiltro'],
                     $ArrayValores[$nombreModelo]['campoclave'],
                      $ArrayValores[$nombreModelo]['camporef']);
                    }
                    $datos[$IdControl]=[''=>yii::t('base.verbs','--Seleccione un Valor--')]+$datos[$IdControl];
                   }
             }else{/*Se trata de datos directametne */
               $datos=$source;
           }
           $datosCombo=[];
          foreach($datos as $clave=>$datitos){
              $datosCombo[$clave]=$this->generateHtml($datitos);
          }
          // print_r($datosCombo);die(); 
          return Json::encode($datosCombo);
          
      }else{
          if($isremote=='yes'){               
             $modelo=array_keys($source)[0];
             $clase= new $modelo;
             if($clase instanceof ComboHelper){
                 $funcion=$source[$modelo]['campofiltro'];
                $datos=$modelo::{$funcion}($valorfiltro);
             }else{
                  $datos=ComboHelper::getCboGeneral(
                     $valorfiltro,
                     $modelo,
                     $source[$modelo]['campofiltro'],
                     $source[$modelo]['campoclave'],
                      $source[$modelo]['camporef']);
             }
            $datos=[''=>yii::t('base.verbs','--Seleccione un Valor--')]+$datos;
           }else{/*Se trata de datos directametne */
               $datos=$source;
           }
          return $this->generateHtml($datos);   
        }
      } 
        private function generateHtml($datos){
           return  Html::renderSelectOptions('', $datos);
        }
}