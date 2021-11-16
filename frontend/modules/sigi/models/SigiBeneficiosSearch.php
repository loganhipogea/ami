<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiCargos;

/**
 * SigiCargosSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiCargos`.
 */
class SigiBeneficiosSearch extends SigiBeneficios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['codcargo', 'descargo', 'esegreso', 'regular'], 'safe'],
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
        $query = SigiBeneficios::find();

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

        $query->andFilterWhere(['like', 'codcargo', $this->codcargo])
            ->andFilterWhere(['like', 'descargo', $this->descargo])
            ->andFilterWhere(['like', 'esegreso', $this->esegreso])
            ->andFilterWhere(['like', 'regular', $this->regular]);

        return $dataProvider;
    }
}
