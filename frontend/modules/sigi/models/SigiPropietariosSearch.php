<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiPropietarios;

/**
 * EdificiosSearch represents the model behind the search form of `\frontend\modules\sigi\models\Edificios`.
 */
class SigiPropietariosSearch extends SigiPropietarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id', 'edificio_id','cargo_id','grupo_id'], 'integer'],
            [['edificio_id','codepa','nombre','correo','dni'], 'safe'],
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
        $query = SigiPropietarios::find();

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
            'edificio_id' => $this->edificio_id])->
            andFilterWhere(['like','codepa', $this->codepa])->
            andFilterWhere(['like','correo' , $this->correo])->
             andFilterWhere(['like','dni', $this->dni])->
              andFilterWhere(['like','nombre' , $this->nombre]);
//ECHO $query->createCommand()->rawSql;die();
        return $dataProvider;
    }
    public function searchByUnidad($idunidad)
    {
        $query = SigiPropietarios::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

       /* $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }*/

        // grid filtering conditions
       /* $query->andFilterWhere([
            'edificio_id' => $this->edificio_id,
            'cargo_id' => $this->cargo_id,
            'tasamora' => $this->tasamora,
            'grupo_id' => $this->grupo_id,
             'regular' => $this->regular,
            'montofijo' => $this->montofijo,
            'frecuencia' => $this->frecuencia,
            'tipomedidor' => $this->frecuencia,
        ]);*/
$query->andFilterWhere([
            'unidad_id' => $idunidad
                    ]);
        return $dataProvider;
    } 
}