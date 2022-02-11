<?php

namespace frontend\modules\op\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\OpOtra;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class OpOtraSearch extends OpOtra
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codtra', 'descripcion', 'placa', 'fsalida'], 'safe'],
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
        $query = OpOtra::find();

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
        $query->andWhere([
            'vale_id' => $idvale,
           
        ]);
        $query->andFilterWhere(['codtra', $this->codtra])
        ->andFilterWhere(['like', 'descripcion', $this->descripcion])
       ->andFilterWhere(['like', 'placa', $this->placa])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])
                
                ;
        
//echo $query->createCommand()->rawSql;
        return $dataProvider;
    }
}
