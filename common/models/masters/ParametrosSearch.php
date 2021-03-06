<?php

namespace common\models\masters;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\config\Parametros;

/**
 * ParametrosSearch represents the model behind the search form of `common\models\masters\Parametros`.
 */
class ParametrosSearch extends Parametros
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codparam', 'desparam', 'explicacion', 'tipodato', 'activo'], 'safe'],
            [['longitud'], 'integer'],
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
        $query = Parametros::find();

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
            'longitud' => $this->longitud,
        ]);

        $query->andFilterWhere(['like', 'codparam', $this->codparam])
            ->andFilterWhere(['like', 'desparam', $this->desparam])
            ->andFilterWhere(['like', 'explicacion', $this->explicacion])
            ->andFilterWhere(['like', 'tipodato', $this->tipodato])
            ->andFilterWhere(['like', 'activo', $this->activo]);

        return $dataProvider;
    }
}
