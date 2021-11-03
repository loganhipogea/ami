<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiLecturas;

/**
 * EdificiosSearch represents the model behind the search form of `\frontend\modules\sigi\models\Edificios`.
 */
class SigiLecturasSearch extends SigiLecturas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id', 'edificio_id','cargo_id','grupo_id'], 'integer'],
            [['unidad_id','edificio_id','mes','anio','suministro_id','facturable'], 'safe'],
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
    public function searchBySuministro($idsuministro,$params)
    {
        $query = SigiLecturas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
         $this->load($params);
$query->andWhere([
            'suministro_id' => $idsuministro
                    ]);
     
        $query->andFilterWhere([
            'mes' => $this->mes,
            'anio' => $this->anio,
            'facturable' => $this->facturable,
        ]);
          
        return $dataProvider;
    }
    
    public function searchByEdificio($id)
    {
        $query = SigiSuministros::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       
$query->andFilterWhere([
            'edificio_id' => $id
                    ]);
        return $dataProvider;
    }
    
    public function search($params){
         $query = SigiLecturas::find();
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
        $query->andFilterWhere(['edificio_id' => $this->edificio_id])->
            andFilterWhere(['unidad_id' => $this->unidad_id])->
          andFilterWhere(['tipo' => $this->tipo])->
                 andFilterWhere(['like','codpro', $this->codpro])->
              andFilterWhere(['like','codsuministro', $this->codsuministro])->   
             andFilterWhere(['codum' => $this->codum]);
            
        
        return $dataProvider;
    }
    
    
   
}