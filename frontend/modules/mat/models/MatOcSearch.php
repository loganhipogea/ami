<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatOc;

/**
 * MatOcSearch represents the model behind the search form of `frontend\modules\mat\models\MatOc`.
 */
class MatOcSearch extends MatOc
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['numero', 'fecha', 'codpro', 'codtra', 'descripcion', 'textointerno', 'fpago', 'texto', 'codest', 'codmon'], 'safe'],
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
        $query = MatOc::find();

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
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'numero', $this->numero])
            ->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'codpro', $this->codpro])
            ->andFilterWhere(['like', 'codtra', $this->codtra])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'textointerno', $this->textointerno])
            ->andFilterWhere(['like', 'fpago', $this->fpago])
            ->andFilterWhere(['like', 'texto', $this->texto])
            ->andFilterWhere(['like', 'codest', $this->codest])
            ->andFilterWhere(['like', 'codmon', $this->codmon]);

        return $dataProvider;
    }
}
