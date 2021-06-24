<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiPorpagar;
USE common\models\masters\Clipro;
use yii\db\Expression;

/**
 * SigiPorpagarSearch represents the model behind the search form of `\frontend\modules\sigi\models\SigiPorpagar`.
 */
class SigiSancionesSearch extends SigiSanciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'edificio_id', 'unidad_id','propietario_id'], 'integer'],
            [['edificio_id', 'unidad_id','propietario_id', 'fecha','fecha1','monto','monto1', 'focurrencia','focurrencia1', 'detalle'], 'safe'],
            //[['monto', 'igv', 'monto_usd'], 'number'],
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
        $query = SigiSanciones::find();

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
            'unidad_id' => $this->unidad_id,
            'propietario_id' => $this->propietario_id,
            'monto' => $this->monto,
            /*'igv' => $this->igv,
            'monto_usd' => $this->monto_usd,*/
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);
           /* ->andFilterWhere(['like', 'codpresup', $this->codpresup])
            ->andFilterWhere(['like', 'glosa', $this->glosa])
            //->andFilterWhere(['like', 'fechadoc', $this->fechadoc])
            ->andFilterWhere(['like', 'codestado', $this->codestado])*/
           // ->andFilterWhere(['like', 'detalle', $this->detalle]);

         if(!empty($this->fecha) && !empty($this->fecha1)){
         $query->andFilterWhere([
             'between',
             'fecha',
             $this->openBorder('fecha',false),
             $this->openBorder('fecha1',true)
                        ]);  
            } 
            
          if(!empty($this->fecha) && !empty($this->fecha1)){
         $query->andFilterWhere([
             'between',
             'fecha',
             $this->openBorder('fecha',false),
             $this->openBorder('fecha1',true)
                        ]);  
            } 
         if(!empty($this->focurrencia) && !empty($this->focurrencia1)){
         $query->andFilterWhere([
             'between',
             'focurrencia',
             $this->openBorder('focurrencia',false),
             $this->openBorder('focurrencia1',true)
                        ]);  
            }
        return $dataProvider;
    }
}
