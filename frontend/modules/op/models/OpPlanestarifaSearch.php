<?php

namespace frontend\modules\op\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\op\models\OpPlanestarifa;

/**
 * OpPlanestarifaSearch represents the model behind the search form of `frontend\modules\op\models\OpPlanestarifa`.
 */
class OpPlanestarifaSearch extends OpPlanestarifa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nhoras'], 'integer'],
            [['codigo', 'hinicio_nocturno'], 'safe'],
            [['porc_dominical', 'porc_feriado', 'porc_nocturno', 'porc_localizacion', 'porc_refrigerio', 'porc_hextras'], 'number'],
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
        $query = OpPlanestarifa::find();

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
            'porc_dominical' => $this->porc_dominical,
            'porc_feriado' => $this->porc_feriado,
            'porc_nocturno' => $this->porc_nocturno,
            'porc_localizacion' => $this->porc_localizacion,
            'porc_refrigerio' => $this->porc_refrigerio,
            'porc_hextras' => $this->porc_hextras,
            'nhoras' => $this->nhoras,
        ]);

        $query->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'hinicio_nocturno', $this->hinicio_nocturno]);

        return $dataProvider;
    }
}
