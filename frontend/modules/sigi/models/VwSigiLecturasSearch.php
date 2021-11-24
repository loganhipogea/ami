<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\VwSigiLecturas;


/**
 * SigiUnidadesSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiUnidades`.
 */
class VwSigiLecturasSearch extends VwSigiLecturas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        
            [['codigo','codtipo', 'numero', 'nombre','mes','anio','flectura','flectura1','edificio_id'], 'safe'],
        
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
    public function searchByCuentasPor($cuentasid,$params)
    {
        $query = VwSigiLecturas::find();

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
$query->andWhere(['cuentaspor_id' => $cuentasid]);
        $query->andFilterWhere(['like', 'codtipo', $this->codtipo])
                 ->andFilterWhere(['unidad_id'=> $this->unidad_id])
                ->andFilterWhere(['edificio_id'=> $this->edificio_id])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['like', 'codsumnistro', $this->codsuministro])
                ->andFilterWhere(['like', 'codedificio', $this->codedificio])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);
if(!empty($this->flectura) && !empty($this->flectura1)){
         $query->andFilterWhere([
             'between',
             'flectura',
             $this->openBorder('fechaprog',false),
             $this->openBorder('fechaprog1',true)
                        ]);   
        }
        return $dataProvider;
    }
    
     public function search($params)
    {
        $query = VwSigiLecturas::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->unidad_id,
            'mes' => $this->mes,
            'anio' => $this->anio,
            //'facturable' => $this->facturable,
            'edificio_id' => $this->edificio_id,
            
           // 'area' => $this->area,
           // 'participacion' => $this->participacion,
           // 'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'numero', $this->numero])
                
            ->andFilterWhere(['like', 'codigo', $this->codigo]);
if(!empty($this->flectura) && !empty($this->flectura1)){
         $query->andFilterWhere([
             'between',
             'flectura',
             $this->openBorder('flectura',false),
             $this->openBorder('flectura1',true)
                        ]);   
        }
        return $dataProvider;
    }
      public function searchByEdificio($edificio_id)
    {
        $query = SigiUnidades::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->where([
            'edificio_id' => $edificio_id,
           // 'npisos' => $this->npisos,
        ]);
        // grid filtering conditions
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);
        return $dataProvider;
    }
    
     public function searchByFacturacionParams($edificio_id,$mes,$anio,$params)
    {
        $query = VwSigiLecturas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
           'pagination'=>['pageSize'=>200]
        ]);
$this->load($params);
        $query->where([
            'edificio_id' => $edificio_id,
           'facturable'=>'1',
            'mes'=>$mes,
            'anio'=>$anio
        ]);
        // grid filtering conditions
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'codigo', $this->codigo]);
        return $dataProvider;
    }
    
}

