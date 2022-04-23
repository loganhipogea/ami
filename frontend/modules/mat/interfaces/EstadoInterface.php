<?php

namespace frontend\modules\mat\interfaces;

/*Esta interfaz es base
 * para los colecrtores como claulan las particiapciones en
 * la facturacion
 */
interface  EstadoInterface { 
    /*  
     */
    //public function factorProRateo();
    
   public function isCreado();
   public function isAprobado();
   public function isAnulado();
   public function isBloqueado();
   
    
}
