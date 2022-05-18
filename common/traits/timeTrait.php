<?php
/*
 * TRAIT DE USO general para saber 
 * por ejemplo si una feha e sferiado o no
 */
namespace common\traits;
use yii;
use Carbon\Carbon;
use common\helpers\RangeDates;
trait timeTrait
{
    
   

    private function holyDays(){
        $anio=date('Y');
        return [       
        $anio.'-11-01',
        $anio.'-12-25',
        $anio.'-01-01',
        $anio.'-10-08',
        $anio.'-05-01',
       $anio.'-06-29',
        $anio.'-07-28',
        $anio.'-07-29',
        $anio.'-08-30',
        $anio.'-11-01',
       $anio.'-12-25',
       // $anio.'-04-10',
             ];
    }
    
    public function isHolyDay(Carbon $fecha){
        
        return ($fecha->isSunday() /*or $fecha->isSaturday()*/ or
                in_array($fecha->format('Y-m-d'),$this->holyDays())
                )?true:false;
    }
    
    /*
     * PARA SABER SI UNA FEHA ESTA DENTRO UN INTERVALO
     */
    public function betweenDate( Carbon $fecha,
                             Carbon $finicio,
                             Carbon $ftermino,
                        $withBorder=true){
         if($withBorder){
             return($fecha->greaterThanOrEqualTo($finicio) && 
            $fecha->lessThanOrEqualTo($ftermino))?true:false;
         }else{
            return($fecha->greaterThan($finicio) && 
            $fecha->lessThan($ftermino))?true:false; 
         }
        
    }
    
    /*
     * PARA SABER SI UN RANGOD E FECHAS 
     * ESTA CONTENIDO EN OTRO RANGO DE FECHAS
     * $rango  : DateRange  , rango que se va a buscar
     * $hostRango: DateRango rango donde se va a buscar 
     * Devuelve 
     * true: Quiere decir que si opuede considerarse dentro del valordel rango a bsucar
     * false: eSTA Fuera delos valores del rango a bsucar 
     */
    public function isRangeIntoOtherRange(RangeDates $rangeCompare, //rango a buscar
            RangeDates $rangeSearch, //rANGO A COMPARAR 
            $withBorder=true){
        if(is_null($rangeCompare) or is_null($rangeSearch))return false;
        /*yii::error('****inicinac********');
         yii::error($rangeSearch->initialDate->format('Y-m-d H:i'));
        yii::error($rangeSearch->finalDate->format('Y-m-d H:i'));*/
        return (
                 $this->intofisrtCondition($rangeCompare, $rangeSearch, $withBorder) &&
                 (
                  $this->intoSecondCondition($rangeCompare, $rangeSearch) or
                  $this->intoThirdCondition($rangeCompare, $rangeSearch) or
                  $this->intoFourthCondition($rangeCompare, $rangeSearch)
                   )
                 );
    }
   
    
    /*
     * Saber si el rango a comparar  no esta fuera de las fronteras del rango
     * a buscar
     * 
     */
  private function intofisrtCondition(RangeDates $rangeCompare, 
          RangeDates $rangeSearch,$withBorder=true){
      /*yii::error('***primera condicion**');
       yii::error($rangeSearch->initialDate->format('H:i'));
        yii::error($rangeSearch->finalDate->format('H:i'));*/
      if($withBorder){
          /*yii::error(!($rangeCompare->finalDate->lessThanOrEqualTo($rangeSearch->initialDate) or
             $rangeCompare->initialDate->greaterThanOrEqualTo($rangeSearch->finalDate)));
          */
           return !($rangeCompare->finalDate->lessThanOrEqualTo($rangeSearch->initialDate) or
             $rangeCompare->initialDate->greaterThanOrEqualTo($rangeSearch->finalDate)); 
             
         }else{
             /*yii::error(($rangeCompare->finalDate->lessThan($rangeSearch->initialDate) or
             $rangeCompare->initialDate->greaterThan($rangeSearch->finalDate)));*/
             
            return !($rangeCompare->finalDate->lessThan($rangeSearch->initialDate) or
             $rangeCompare->initialDate->greaterThan($rangeSearch->finalDate));        
         }
  }

private function intoSecondCondition(RangeDates $rangeCompare, 
          RangeDates $rangeSearch){   
    /* yii::error('**Segunda condicion**');
         yii::error('Diferencia de tfc-to : '.$rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->initialDate));
         yii::error('Duracion del rango pequeni : '.$rangeCompare->duration);
          yii::error('Porcentaje de tolerancia : '.(1-$rangeCompare->tolerance));
           yii::error('Comparando si tfc-to > ()%duracion: '.($rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->initialDate) >= (1-$rangeCompare->tolerance)*$rangeCompare->duration)?'ok':'no cumple');
            yii::error('Comparando toc < to : '.($rangeCompare->initialDate->lessThanOrEqualTo($rangeSearch->initialDate))?'ok':'falso');
         yii::error($rangeSearch->initialDate->format('H:i'));
        yii::error($rangeSearch->finalDate->format('H:i'));*/
            /* yii::error((($rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->initialDate) >= (1-$rangeCompare->tolerance)*$rangeCompare->duration) &&
           ($rangeCompare->initialDate->lessThanOrEqualTo($rangeSearch->initialDate))
           ));*/
             
            return (($rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->initialDate) >= (1-$rangeCompare->tolerance)*$rangeCompare->duration) &&
           ($rangeCompare->initialDate->lessThanOrEqualTo($rangeSearch->initialDate))
           );
           
  }
 
  private function intoThirdCondition(RangeDates $rangeCompare, 
          RangeDates $rangeSearch){  
           /* yii::error('**Tercera condicion**');
       yii::error('Comparando toc >=to : '.($rangeCompare->initialDate->greaterThanOrEqualTo($rangeSearch->initialDate))?'yes':'falso');
        yii::error($rangeCompare->initialDate->format('H:i'));
       yii::error($rangeCompare->finalDate->format('H:i'));
        yii::error($rangeSearch->initialDate->format('H:i'));
        yii::error($rangeSearch->finalDate->format('H:i'));
       yii::error('Comparando tfc <= tf : '.($rangeCompare->finalDate->lessThanOrEqualTo($rangeSearch->finalDate))?'yes':'falso');
        yii::error('Porcentaje de tolerancia : '.(1-$rangeCompare->tolerance));
          */
          
          $valida=(($rangeCompare->initialDate->greaterThanOrEqualTo($rangeSearch->initialDate)) &&
           ($rangeCompare->finalDate->lessThanOrEqualTo($rangeSearch->finalDate))
           );
         // yii::error($valida);
         return $valida;
           
  }

  
  private function intoFourthCondition(RangeDates $rangeCompare, 
          RangeDates $rangeSearch){  
  /*yii::error('**Cuarta  condicion**');
       yii::error('Diferencia de tfc-tf : '.($rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->finalDate))?'yes':'no');
         yii::error('Duracion del rango pequeni : '.$rangeCompare->duration);
          yii::error('Tolerancia del rango grande : '.($rangeCompare->tolerance));
           yii::error('Comparando si tfc-tf < tolerancia*duracion: '.($rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->finalDate) < ($rangeCompare->tolerance)*$rangeCompare->duration)?'ok':'no cumple');
            yii::error('Comparando toc <= tf : '.($rangeCompare->initialDate->lessThanOrEqualTo($rangeSearch->finalDate))?'ok':'falso');
        yii::error((($rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->finalDate) < ($rangeCompare->tolerance)*$rangeCompare->duration) &&
           ($rangeCompare->initialDate->lessThanOrEqualTo($rangeSearch->finalDate))
           ));*/
         return (($rangeCompare->getDiff($rangeCompare->finalDate,$rangeSearch->finalDate) < ($rangeCompare->tolerance)*$rangeCompare->duration) &&
           ($rangeCompare->initialDate->lessThanOrEqualTo($rangeSearch->finalDate))
           );
           
  }
  
  /*Verifica que rangecompare
   * no coincide en nada con 
   * RangeSearch, es decir NO SE TRASLAPAN
   * 
   */
  public function traslapeRange(RangeDates $rangeCompare, 
          RangeDates $rangeSearch){
      return !($rangeSearch->initialDate->greaterThan($rangeCompare->finalDate) or
       $rangeCompare->initialDate->greaterThan($rangeSearch->finalDate));
  }
  
  
  public function isRangeInOtherGroupRanges(RangeDates $rangeCompare,$groupRanges,$withBorders=true){
      $retorno=false;
      foreach($groupRanges as $rangeSearch){
          if($this->isRangeIntoOtherRange($rangeCompare, $rangeSearch, $withBorders)){
              $retorno=true;
              break;
          }
      }
      return $retorno;
  }
 
  
}
