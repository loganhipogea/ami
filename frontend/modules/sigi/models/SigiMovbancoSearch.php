<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiMovbanco;

/**
 * SigiMovimientosPreSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiMovimientosPre`.
 */
class SigiMovbancoSearch extends SigiMovbanco
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id',  'edificio_id', 'cuenta_id', ], 'integer'],
            [['fopera','fopera1','fval1', 'fval',  'descripcion', 'monto','diferencia','monto_conciliado','monto1'], 'safe'],
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
        $query = SigiMovbanco::find();

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
            //'cuenta_id' => $this->cuenta_id,
            'edificio_id' => $this->edificio_id,
            'cuenta_id' => $this->cuenta_id,
           // 'monto' => $this->monto,
            //'tipomov' => $this->tipomov,
           // 'monto_usd' => $this->monto_usd,
           // 'user_id' => $this->user_id,
        ]);
       
       
        $query->andFilterWhere(['like', 'monto_conciliado', $this->monto_conciliado])
            ->andFilterWhere(['like', 'diferencia', $this->diferencia])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        if(!empty($this->fopera) && empty($this->fopera1))
          $query->andFilterWhere([
            'fopera' => $this->swichtDate ('fopera', false),
             ]);
        if(!empty($this->fopera) && !empty($this->fopera1)){
         $query->andFilterWhere([
             'between',
             'fopera',
              $this->swichtDate ('fopera', false),
              $this->swichtDate ('fopera1', false),
             //$this->openBorder('fopera',false),
            // $this->openBorder('fopera1',true)
                        ]);  
     }   
     
     if(!empty($this->monto) && empty($this->monto1))
          $query->andFilterWhere([
            'monto' => 'like', 'diferencia', $this->monto
                  ]);
        if(!empty($this->monto) && !empty($this->monto1)){
         $query->andFilterWhere([
             'between',
             'monto',
              $this->monto,
              $this->monto1,
             //$this->openBorder('fopera',false),
            // $this->openBorder('fopera1',true)
                        ]);  
     }   
     
        return $dataProvider;
    
   }
}
