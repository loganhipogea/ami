<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiTransferencias;


/**
 * SigiTransferenciasSearch represents the model behind the search form of `\frontend\modules\sigi\models\SigiTransferencias`.
 */
class SigiTransferenciasSearch extends SigiTransferencias
{
    /**
     * {@inheritdoc}
     */
    public function attributes() {
        return array_merge(parent::attributes(),['unidad.numero']);
    }
    
    public function rules()
    {
        return [
            [['id', 'edificio_id', 'unidad_id', 'parent_id'], 'integer'],
            [['edificio_id', 'fecha', 'tipotrans', 'nombre', 'correo', 'dni','unidad.numero'], 'safe'],
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
        $query = SigiTransferencias::find();

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
       //$query->joinWith('unidad d');
       // $query->andFilterWhere(['like','numero',$this->getAttribute('unidad.numero')]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'edificio_id' => $this->edificio_id,
            'unidad_id' => $this->unidad_id,
            'parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', 'fecha', $this->fecha])
            ->andFilterWhere(['like', 'tipotrans', $this->tipotrans])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'correo', $this->correo])
            ->andFilterWhere(['like', 'dni', $this->dni]);

        return $dataProvider;
    }
}
