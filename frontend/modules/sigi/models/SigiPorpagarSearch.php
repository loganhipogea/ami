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
class SigiPorpagarSearch extends SigiPorpagar
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'edificio_id', 'unidad_id'], 'integer'],
            [['codocu', 'codpresup', 'glosa', 'fechadoc','fechadoc1','monto','monto1', 'codestado', 'detalle'], 'safe'],
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
public function getClipro()
    {
        return $this->hasOne(Clipro::className(), ['codpro' => 'codpro']);
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
        $query = SigiPorpagar::find();

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
           // 'monto' => $this->monto,
            'igv' => $this->igv,
            'monto_usd' => $this->monto_usd,
        ]);

        $query->andFilterWhere(['like', 'codocu', $this->codocu])
            ->andFilterWhere(['like', 'codpresup', $this->codpresup])
            ->andFilterWhere(['like', 'glosa', $this->glosa])
            //->andFilterWhere(['like', 'fechadoc', $this->fechadoc])
            ->andFilterWhere(['like', 'codestado', $this->codestado])
            ->andFilterWhere(['like', 'detalle', $this->detalle]);

         if(!empty($this->fechadoc) && !empty($this->fechadoc1)){
         $query->andFilterWhere([
             'between',
             'fechadoc',
             $this->openBorder('fechadoc',false),
             $this->openBorder('fechadoc1',true)
                        ]);  
            } 
         if(!empty($this->monto) && !empty($this->monto1)){
         $query->andFilterWhere([
             'between',
             'monto',
             $this->monto-0.0001,
             $this->monto1+0.0001,
                        ]);  
            }
        return $dataProvider;
    }
}
