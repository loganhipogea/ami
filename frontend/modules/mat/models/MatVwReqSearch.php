<?php

namespace frontend\modules\mat\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatDetvale;
use frontend\modules\mat\models\MatDetreq;

/**
 * MatReqSearch represents the model behind the search form of `frontend\modules\mat\models\MatReq`.
 */
class MatVwReqSearch extends MatVwReq
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           
            [['id','ap', 'codart', 'um', 'item','am','fechaprog','fechasol','fechaprog1',
                'fechasol1','descridetalle','numero','os_id','detos_id'], 'safe'],
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
        $query = MatVwReq::find();

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

        
       
        $query->andFilterWhere(['like', 'codart', $this->codart])
        ->andFilterWhere(['like', 'descridetalle', explode('%',$this->descridetalle)])
            //->andFilterWhere(['like', 'fechaprog', $this->fechaprog])
           // ->andFilterWhere(['like', 'fechasol', $this->fechasol])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])                  
                ;
        
         if(!empty($this->fechasol) && !empty($this->fechasol1)){
         $query->andFilterWhere([
             'between',
             'fechasol',
             $this->openBorder('fechasol',false),
             $this->openBorder('fechasol1',true)
                        ]);   
        }
        
         if(!empty($this->fechaprog) && !empty($this->fechaprog1)){
         $query->andFilterWhere([
             'between',
             'fechaprog',
             $this->openBorder('fechaprog',false),
             $this->openBorder('fechaprog1',true)
                        ]);   
        }
        //echo  $query->createCommand()->rawSql;DIE();
        return $dataProvider;
    }
    
    public function search_by_os($id_os,$params){
         $query = MatVwReq::find();

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
        $query->andWhere(['os_id'=>$id_os]);
        $query->andWhere(['tipo'=> MatDetreq::TIPO_MATERIALE]);
        $query->andFilterWhere(['like', 'codart', $this->codart])
        ->andFilterWhere(['detos_id'=> $this->detos_id])
        ->andFilterWhere(['like', 'descridetalle', explode('%',$this->descridetalle)])
            //->andFilterWhere(['like', 'fechaprog', $this->fechaprog])
           // ->andFilterWhere(['like', 'fechasol', $this->fechasol])
            //->andFilterWhere(['like', 'descripcion', explode('%',$this->descripcion)])                  
                ;
        
        //echo  $query->createCommand()->rawSql;DIE();
        return $dataProvider;
    }
    
}
