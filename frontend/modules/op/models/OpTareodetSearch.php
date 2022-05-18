<?php

namespace frontend\modules\op\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\op\models\OpTareo;

/**
 * OpTareoSearch represents the model behind the search form of `frontend\modules\op\models\OpTareo`.
 */
class OpTareodetSearch extends OpTareodet
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tareo_id','hinicio','hfin','codtra',
                'proc_id', 'os_id', 
                'detos_id',
                'tarifa_id','costo','htotales',
                
                ], 'safe'],
            [['id', 'tareo_id',
                'proc_id', 'os_id', 
                'detos_id',
                'tarifa_id',
                
                ], 'integer'],
            
        ];
    }
/**
 * @property string $costo
 * @property string $htotales
 *
 * @property Trabajadores $codtra0
 * @property OpOs $os
 * @property OpTareo $tareo
 * @property OpProcesos $proc
 * @property OpOsdet $detos
 * @property OpPlanestarifa $tarifa
 */
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
    public function search($tareo_id,$params)
    {
        $query = OpTareodet::find();

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
         $query->andWhere(['tareo_id'=>$tareo_id]);
        // grid filtering conditions
        $query->andFilterWhere([
            //'id' => $this->id,
           // 'direcc_id' => $this->direcc_id,
            'proc_id' => $this->proc_id,
            'os_id' => $this->os_id,
            'detos_id' => $this->detos_id,
            'codtra'=>$this->codtra,
        ]);

       
        return $dataProvider;
    }
}
