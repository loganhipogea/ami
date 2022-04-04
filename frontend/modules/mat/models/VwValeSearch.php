<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatReq;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class VwValeSearch extends VwVale
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            
            [['descripcion', 'codart', 'numero', 'fecha'], 'safe'],
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
    public function search_by_req($idreq)
    {
        $query = VwVale::find();

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
           
        ]);
        
        $query->andFilterWhere(['like', 'codart', $this->codart])
           // ->andFilterWhere(['like', 'descripcion', $this->descripcion])
           ->andFilterWhere(['like', 'numero', $this->numero])
           // ->andFilterWhere(['like', 'fechasol', $this->fechasol])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])
                
                ;
        if(!empty($this->descripcion))
        $query->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)]);
//echo $query->createCommand()->rawSql;
        return $dataProvider;
    }
    
     public function search($params)
    {
        $query = VwVale::find();

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
        

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'item', $this->item])
            ->andFilterWhere(['like', 'codart', $this->codart])
            ->andFilterWhere(['like', 'um', $this->um])
            //->andFilterWhere(['like', 'cant', $this->texto])
            ->andFilterWhere(['like', 'cant', $this->cant]);

        return $dataProvider;
    }
    
    
}
