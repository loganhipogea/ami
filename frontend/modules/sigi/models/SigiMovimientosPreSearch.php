<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiMovimientosPre;

/**
 * SigiMovimientosPreSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiMovimientosPre`.
 */
class SigiMovimientosPreSearch extends SigiMovimientosPre
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'idop', 'edificio_id', 'cuenta_id', 'user_id'], 'integer'],
            [['fechaop', 'fechacre', 'tipomov', 'glosa', 'activo','monto_conciliado'], 'safe'],
            [['monto', 'igv', 'monto_usd'], 'number'],
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
        $query = SigiMovimientosPre::find();

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
            'idop' => $this->idop,
            'edificio_id' => $this->edificio_id,
            'cuenta_id' => $this->cuenta_id,
            'monto' => $this->monto,
            'igv' => $this->igv,
            'monto_usd' => $this->monto_usd,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'fechaop', $this->fechaop])
            ->andFilterWhere(['like', 'fechacre', $this->fechacre])
            ->andFilterWhere(['like', 'tipomov', $this->tipomov])
            ->andFilterWhere(['like', 'glosa', $this->glosa])
            ->andFilterWhere(['like', 'activo', $this->activo]);

        return $dataProvider;
    }
}
