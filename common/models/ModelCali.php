<?php
namespace common\models;
use common\interfaces\CalificaInterface;
use Yii;

class ModelCali extends \common\models\base\modelBase
{
    
    private $ses_=null;
    private $fieldsCalificacion=[
                'proc_id',
                'os_id',
                'detos_id'
                ];
    
   public function  __construc($config, CalificaInterface $sesCali){
       $this->ses_=$SesCali;
       parent::__construct($config);
    }
   
   public function calificar(){
       $this->{$this->fieldsCalificacion[0]}=$this->ses_->idProceso;
       $this->{$this->fieldsCalificacion[1]}=$this->ses_->idOs;
        $this->{$this->fieldsCalificacion[2]}=$this->ses_->idDetos;
   }
  
}
