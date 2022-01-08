<?php

namespace frontend\modules\sigi\models;
use common\helpers\h;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\VwKardexPagos;

/**
 * SigiUnidadesSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiUnidades`.
 */
class VwKardexPagosSearch extends VwKardexPagos
{
    public $deudor=null;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
       /* @property int $id
 * @property int $cuentaspor_id
 * @property int $edificio_id
 * @property int $unidad_id
 * @property int $colector_id
 * @property int $grupo_id
 * @property string $monto
 * @property string $igv
 * @property string $grupounidad agrupa  todos los objetos: cochera, depositos  en el mismo departamento  
 * @property string $grupofacturacion Agrupa el documento del recibo, ojo lo hace por departametno o apoderado, MUY IMPORTANTES 
 * @property int $facturacion_id
 * @property int $mes
 * @property string $anio
 * @property int $identidad
 * @property string $fecha
 * @property string $descripcion
 * @property string $detalles
 * @property string $nombreedificio
 * @property string $codigo
 * @property string $direccion
 * @property string $numero
 * @property string $nombre
 * @property string $area
 * @property string $participacion
 * @property string $descargo
 * @property string $codcargo
 * @property string $codgrupo
 * @property string $desgrupo
 * @property string $numerodepa
 * @property string $nombredepa
 * @property string $areadepa
 * @property string $participaciondepa*/
        
        return 
            [  
                // [['fecha', 'anio', 'codmon', 'numrecibo', 'detalles','numero','nombre','codtipo','desunidad','fecha1' ,'cancelado'], 'safe'],
                 [['facturacion_id',  'edificio_id', 'unidad_id'], 'integer'],
                [['mes','anio','monto','nombre','edificio_id',
                    'unidad_id','numero','pagado','fecha','fecha1',
                    'deudor' ,'deuda','aprobado','voucher_id'], 'safe'],
               
            ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VwKardexPagos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>40],
        ]);

        $this->load($params);

       

        // grid filtering conditions
        //$query;

        $query->andFilterWhere(['mes'=> $this->mes])     
             ->andFilterWhere(['anio'=> $this->anio])  
            // ->andFilterWhere(['aprobado'=> '1'])  
                  ->andFilterWhere(['like','numero', $this->numero])  
               // ->andFilterWhere(['like', 'deuda', $this->deuda])
            ->andFilterWhere(['like', 'pagado', $this->pagado])
                 ->andFilterWhere(['edificio_id'=> $this->edificio_id])
                  ->andFilterWhere(['unidad_id'=> $this->unidad_id])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);
        
     if(!is_null($this->deudor)){
            if($this->deudor=='1'){
                $query->andWhere(['>','deuda',h::gsetting('sigi','montominimo_deudor')]); 
                }else{
                $query->andWhere(['<=','deuda',h::gsetting('sigi','montominimo_deudor')]); 
   
                }
        }   
        
        
        
       if(!empty($this->fecha) && !empty($this->fecha1)){
         $query->andFilterWhere([
             'between',
             'fecha',
             $this->openBorder('fecha',true),
             $this->openBorder('fecha1',true)
                        ]);
   }
  /*var_dump($this->deudor,$params);
echo $query->createCommand()->rawSql; die();
         // \yii::error($params,__FUNCTION__);
        //\yii::error($query->createCommand()->rawSql,__FUNCTION__);*/
        return $dataProvider;
    }
     
}
