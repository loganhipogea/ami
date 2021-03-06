<?php

namespace frontend\modules\sigi\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\sigi\models\SigiBenegrupoedificio;

/**
 * SigiBasePresupuestoSearch represents the model behind the search form of `frontend\modules\sigi\models\SigiBasePresupuesto`.
 */
class SigiBenegrupoedificioSearch extends SigiBenegrupoedificio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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
    public function searchByEdificio($edificio_id)
    {
        $query = SigiBenegrupoedificio::find();
        //echo $query->createCommand()->rawSql; DIE();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere([
            'edificio_id' => $edificio_id,
           // 'npisos' => $this->npisos,
        ]);
        // grid filtering conditions
        
        return $dataProvider;
    }
    
     public function searchByGrupo($idgrupo)
    {
        $query = SigiBeneficios::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>['pageSize'=>30],
        ]);

       
        // grid filtering conditions
        $query->andFilterWhere([
            'grupo_id' => $idgrupo
        ]);

        return $dataProvider;
    }
}
