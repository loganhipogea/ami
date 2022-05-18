<?php

namespace frontend\modules\clasi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\clasi\models\ClasiClases;

/**
 * ClasiClasesSearch represents the model behind the search form of `frontend\modules\clasi\models\ClasiClases`.
 */
class ClasiClaseCaracSearch extends ClasiClaseCarac
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'descripcion','clase_id'], 'safe'],
            [['user_id'], 'integer'],
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
        $query = ClasiClaseCarac::find();

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
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
