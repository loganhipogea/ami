<?php
namespace frontend\modules\report\components;
use yii\base\Component;
class Block extends Component
{
    public $x0=0;
    public $y0=0;
    public $width=190;
    //public $height=60;
    public $orden=0;
    //public $rows=0;
    public $scaleRows=15; //Pixeles por fila
    public $data=[]; //array de datos para renderizar la tabla
    public $brokenChilds=[]; //array de blocks partidos 
    public $fontSize=9; //9px
    
   public function getHeight(){
       return $this->rows*$this->scaleRows;
   }
    
   public function setScaleHeight($scale){
       $this->scaleRows=$scale;
       return $this;
   } 
   
  public function setPosition($pos){
      
     }
     
  public function getPosition(){
      return [];
  }
  
  public function render($data){
     $openTable='<table style="border:4px dotted blue; width:'.$this->width.'">';
     $content='';
        foreach($data as $key=>$row){
           $content.= '<tr style="height:'.$this->scaleRows.'px;">';
              foreach($row as $key1=>$value){
                 $content.= '<td align="right" style="font-size:'.$this->fontSize.'"  ><b>'.$value.'</b></td>';
              }
          $content.= ' </tr> ';
        } 
     $closeTable='</table>'; 
     return $openTable.$content.$closeTable;        
  }
  
  /*
   * Parte en 2 bloques un bloque determinado
   * retorna dos obejtos bloque partidos
   * @heightReference: Altura en pixeles medidos de 
   * la cabecera hacia abajo donde se partira 
   *    ----------------------
   *    |                     | heightreference
   *    |                     |
   *    -----------------------
   *    |                     |
   *    |                     |
   *    |                     |
   *    |                     |
   *    -----------------------
   */
  public function split($heightReference){
      if($heightReference >= $this->height) return;
      if(!empty($this->brokenChilds))$this->brokenChilds=[];
      $rowsFirstPart=ceil($heightReference/$this->scaleRows)-1;
      $data1=array_slice($this->data, 0,$rowsFirstPart-1); 
      $data2=array_slice($this->data,$rowsFirstPart);
      /*
       * Creadno el primer bloque
       */
      $block1=clone $this;
      $block1->data=$data1;
      $block1->brokenChilds=[];
      
      /*
       * Creadno el segundo bloque
       */
      $block2=clone $this;
      $block2->data=$data2;
      $block2->setHeader($data1[0]);
      $block2->brokenChilds=[];
      $block2->y0=$this->y0+$block1->height+$this->scaleRows;
      //$block2->data=$data2;
      
      $this->brokenChilds[]=$block1;
       $this->brokenChilds[]=$block2;
       return $this;
  }
  
  /*
   * Coloca el encabezado al data[]
   */
  public function setHeader($rowHeader){
      array_unshift($this->data,$rowHeader);
      return $this;
  }
  
  public function setData(array $data){
      $this->data=$data;
      return $this;
  }
  
   public function getRows(){
       return count($this->data);
   } 
   
   public function setFontSize($size){
      $this->fontSize=$size;
      return $this;
  }
  
  
  
}

