<?php
namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiKardexdepa;
//use common\helpers\h;

/**
 * SigiKardexdepaSearch represents the model behind the search form of `\frontend\modules\sigi\models\SigiKardexdepa`.
 */
class VwSigiKardexdepaSearch extends VwSigiKardexDepa
{

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'facturacion_id', 'operacion_id', 'edificio_id', 'unidad_id', 'mes'], 'integer'],
            [['fecha', 'anio', 'codmon', 'numrecibo', 'detalles','numero','nombre','codtipo','desunidad','fecha1' ,'cancelado','deuda'], 'safe'],
            [['monto', 'igv'], 'number'],
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
        $query = VwSigiKardexdepa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'facturacion_id' => $this->facturacion_id,
            'operacion_id' => $this->operacion_id,
            'edificio_id' => $this->edificio_id,
            'unidad_id' => $this->unidad_id,
            'codtipo' => $this->codtipo,
            'mes' => $this->mes,
            'monto' => $this->monto,
            'igv' => $this->igv,
        ]);

        if($this->cancelado=='1'){
            $query->andFilterWhere(['cancelado'=>$this->cancelado]);
            ///$query->andFilterWhere(['asistio'=>$this->asistio]);
        }else{
            
        }
        
        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'anio', $this->anio])
           // ->andFilterWhere(['deudor'=> ($this->cancelado)?'1':'0'])
            ->andFilterWhere(['like', 'codmon', $this->codmon])
            ->andFilterWhere(['like', 'numrecibo', $this->numrecibo])
                 ->andFilterWhere(['like', 'numero', $this->numero])
                 ->andFilterWhere(['like', 'nombre', $this->nombre])   
                 ->andFilterWhere(['like', 'desunidad', $this->desunidad])    
            ->andFilterWhere(['like', 'detalles', $this->detalles]);
 
 if(!empty($this->fecha) && !empty($this->fecha1)){
         $query->andFilterWhere([
             'between',
             'fechaprog',
             $this->openBorder('fechaprog',false),
             $this->openBorder('fechaprog1',true)
                        ]);
   }
   //echo $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
  
}
