<?php
namespace frontend\modules\report\components;
use frontend\modules\report\components\Block; 
class BlocksBuilder
{
    public $blocks=[];
    public $limitx=210;
    public $limity=297;
    public $x0=10;
    public $y0=10;
    public $marginBetweenBlocks=10; //margen en pixeles
    public $marginY=10; //maregen veritical de la pagina
    public $marginX=10; //maregen veritical de la pagina
    
    
    public function addBlock($orden,Block $block){
        $this->blocks[$orden]=$block;
    }
    
   public function calculateNumPages(){
       $npages=0;
      do {
      $npages++;
      
      }while ( $this->heightCapacity($npages) < $this->heightBlocks());
          return $npages; 
        }
    
   private function heightBlocks($orden=-1){
       $h=0;
       if(empty($this->blocks)) return 0;
       if($orden==-1){
          foreach($this->blocks as $order=>$block){
           $h+=$block->height;
           } 
          return $h+$this->marginBetweenBlocks*(count($this->blocks)-1); 
       }else{
           foreach($this->blocks as $order=>$block){
             $h+=$block->height;
             if($orden==$order)break;
           } 
          return $h+$this->marginBetweenBlocks*($orden-1); 
       }
       
       
   }
   
   public function heightCapacity($npage){
       $heightSpaceFirstPage=$this->limity-$this->marginY-$this->y0;
       if($npage==1){
           return $heightSpaceFirstPage;
       }else{
           //Altura pag 1 + (n-1)*(altura-margenes)
           return $heightSpaceFirstPage+($npage-1)*($this->limity-2*$this->marginY);
       }
   }
   /*
    * Ajusta la escala de la altura de las filas de todos
    * los bloques
    */
   public function setScaleHeightsBlock($scale){
       foreach($this->blocks as $order=>$block){
                $block->setScaleHeight($scale);
                }
   }
   
    /*
    * Ajusta la escala de la fuente de todos
    * los bloques
    */
   public function setSizeFont($size){
       foreach($this->blocks as $order=>$block){
                $block->setFontSize($size);
                }
   }
  
   
   public function organizeBlocks(){
       
   }
   
   
   
   /*
   * dataAreglo
   * [
   *    [$data1]
   *    [$data2]
   * ]
   */
  public function createBlock($orden, $datos){
     if(array_key_exists($orden, $this->blocks))return; 
      $block=new Block();
      $this->addBlock($orden,$this->settingsBlock($orden, $block));
    //$block->rows=0;
    //$block->scaleRows=15; //Pixeles por fila
     //array de datos para renderizar la tabla
    
  }
  
  public function settingsBlock($orden, Block &$block){
      $block->data=$datos;
      $block->x0=$this->limitx;
      $block->y0=$this->limity+($orden-1)*($block->height+$this->marginBetweenBlocks);
  // $block->width=190;
  // $block->height=60;
      $block->orden=$orden; 
      return $block;
  }
  
  public function settingsBlocks(){
      foreach($this->blocks as $orden=>$block){
          $this->settingsBlock($orden, $block);
      }
  }
  
  public function detectSplitBlocks(){
      $splits=[];
      foreach($this->blocks as $orden=>$block){
          
      }
  }
}

