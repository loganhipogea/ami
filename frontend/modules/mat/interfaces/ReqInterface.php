<?php
namespace frontend\modules\mat\interfaces;

/*Esta interfaz es base
 * para los colecrtores como claulan las particiapciones en
 * la facturacion
 */
interface  ReqInterface { 
    /*  
     */
    //public function factorProRateo();
    
   public function getCantReal();
   public function verify_um();
    
}



