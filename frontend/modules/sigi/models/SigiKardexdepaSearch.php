<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiKardexdepa;

/**
 * SigiKardexdepaSearch represents the model behind the search form of `\frontend\modules\sigi\models\SigiKardexdepa`.
 */
class SigiKardexdepaSearch extends SigiKardexdepa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'facturacion_id', 'operacion_id', 'edificio_id', 'unidad_id', 'mes'], 'integer'],
            [['fecha', 'anio', 'codmon', 'numerorecibo', 'detalles','cancelado','mes'], 'safe'],
            [['monto', 'igv'], 'number'],
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
        $query = SigiKardexdepa::find();

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
            'facturacion_id' => $this->facturacion_id,
            'operacion_id' => $this->operacion_id,
            'edificio_id' => $this->edificio_id,
            'unidad_id' => $this->unidad_id,
            'mes' => $this->mes,
            'monto' => $this->monto,
            'igv' => $this->igv,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'anio', $this->anio])
            ->andFilterWhere(['like', 'codmon', $this->codmon])
            ->andFilterWhere(['like', 'numerorecibo', $this->numerorecibo])
            ->andFilterWhere(['like', 'detalles', $this->detalles]);

        return $dataProvider;
    }
    
    
    public function searchByResi($unidad_id,$params)
    {
        $query = SigiKardexdepa::find();
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
            'unidad_id' => $unidad_id,
             'cancelado' => $this->cancelado,
            'mes' => $this->mes,
           // 'historico' =>'0',
            'aprobado' => '1',
        ]);

        

        return $dataProvider;
    }
}
