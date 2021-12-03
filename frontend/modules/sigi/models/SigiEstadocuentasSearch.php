<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiEstadocuentas;
use frontend\modules\sigi\models\VwSigiResuestadocuenta;

/**
 * SigiEstadocuentasSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiEstadocuentas`.
 */
class SigiEstadocuentasSearch extends SigiEstadocuentas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'edificio_id', 'cuenta_id'], 'integer'],
            [['saldmesant', 'ingresos', 'egresos', 'saldfinal', 'saldecuenta', 'salddif'], 'number'],
            [['mes', 'anio'], 'safe'],
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
        $query = SigiEstadocuentas::find();

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
            'edificio_id' => $this->edificio_id,
            'cuenta_id' => $this->cuenta_id,
            'saldmesant' => $this->saldmesant,
            'ingresos' => $this->ingresos,
            'egresos' => $this->egresos,
            'saldfinal' => $this->saldfinal,
            'saldecuenta' => $this->saldecuenta,
            'salddif' => $this->salddif,
        ]);

        $query->andFilterWhere(['like', 'mes', $this->mes])
            ->andFilterWhere(['like', 'anio', $this->anio]);

        return $dataProvider;
    }
    
   public function resumenIngresoMes(){
        $query = SigiEstadocuentas::find();
         $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
       $query->andWhere($this->whereFechas('fopera'))
               ->andWhere(['ingreso'=>'1']);
      return $dataProvider;
   }
   
  
   
}
