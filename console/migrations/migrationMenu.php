<?php
namespace console\migrations;
use yii\db\Migration;

/*
 * Clase definida para ayudar asimplificar los procesos de migracion 
 * valido solo para MYSQL
 * uSELA Y VERA COMO LE SIMPLKIFICA LA VIDA 
 */
class migrationMenu extends baseMigration
{
    const TABLE_MENU='{{%menu}}' ;
    const TABLE_ROUTE='{{%auth_item}}' ;
    
    public static function insertOption($option,$route,$optionParent=null){   
             if(!is_null($route))
             self::insertRoute($route);
             $resul=self::existsOptionParent($optionParent);
            if(!self::existsMenu($option, $route, $optionParent))
             (new \yii\db\Query())->createCommand()
                ->insert(self::TABLE_MENU,[
                    'name'=>$option,
                     'parent'=>($resul)?$resul:null,
                    'route'=>$route,
                     'icon'=>'list',
                    ])->execute();
        
    }
    
   public static function deleteOption($option,$route,$optionParent=null){ 
               
             (new \yii\db\Query())->createCommand()
                ->delete(self::TABLE_MENU, [
                    'name'=>$option,
                    'parent'=>$optionParent,
                    'route'=>$route,
                     'icon'=>'list',
                    ])->execute();
    } 
    
   private static function existsOptionParent($optionParent){
      $result=  (new \yii\db\Query())->from(self::TABLE_MENU)
              ->andWhere(['name'=>$optionParent])->all();
      if(count($result)>0)return $result[0]['id'];
      return false;
   }  
   private static function insertRoute($route){
      if(!self::existsRoute($route)){
        (new \yii\db\Query())->createCommand()
                ->insert(self::TABLE_ROUTE,['name'=>$route,'type'=>2])
                ->execute();
      }
   }   
   
   private static  function existsRoute($route){
      $result=  (new \yii\db\Query())->from(self::TABLE_ROUTE)
              ->andWhere(['name'=>$route])->all();
      if(count($result)>0)return $result[0]['name'];
      return false;
   }  
    
   private static  function existsMenu($option,$route,$optionParent=null){
      RETURN  (new \yii\db\Query())->from(self::TABLE_MENU)->
      andWhere([
                    'name'=>$option,
                    'parent'=>$optionParent,
                    'route'=>$route,
                     'icon'=>'list',
                    ])->exists();
   }  
            
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

