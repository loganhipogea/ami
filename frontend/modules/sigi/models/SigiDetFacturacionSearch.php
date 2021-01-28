<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiDetfacturacion;

/**
 * SigiCuentasporSearch represents the model behind the search form of `\frontend\modules\sigi\models\SigiCuentaspor`.
 */
class SigiDetfacturacionSearch extends SigiDetfacturacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'edificio_id', 'mes'], 'integer'],
            [
                ['codocu','edificio_id','unidad_id',
                    'grupocobranza', 'grupo_id', 'identidad',
                    'kardex_id','facturacion_id',
                    'mes', 'anio', 'monto',
                    ], 'safe'],
            [['monto'], 'number'],
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
        $query = SigiCuentaspor::find();

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
            'mes' => $this->mes,
            'anio' => $this->anio,
            'monto' => $this->monto,
            'unidad_id' => $this->unidad_id,
             'indentidad_id' => $this->indentidad_id,
        ]);

       /* $query->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'fedoc', $this->fedoc])
            ->andFilterWhere(['like', 'anio', $this->anio])
            ->andFilterWhere(['like', 'detalle', $this->detalle])
            ->andFilterWhere(['like', 'fevenc', $this->fevenc])
            ->andFilterWhere(['like', 'igv', $this->igv])
            ->andFilterWhere(['like', 'codestado', $this->codestado]);
*/
        return $dataProvider;
    }
    
    public function searchByFactu($idfac)
    {
        $query = SigiDetfacturacion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>30],
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->where([
            'facturacion_id' => $idfac,
            
        ]);

        return $dataProvider;
    }
    
    public function searchByIdentidad($idKardex)
    {
        $query = SigiDetfacturacion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>30],
        ]);

        //$this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->where([
            'kardex_id' => $idKardex,
            
        ]);

        return $dataProvider;
    }
}
