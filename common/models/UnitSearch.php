<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Unit;

/**
 * UnitSearch represents the model behind the search form of `common\models\Unit`.
 */
class UnitSearch extends Unit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tenant_id', 'property_id', 'created_at', 'update_at', 'created_by', 'updated_by', 'deleted', 'deleted_at', 'deleted_by'], 'integer'],
            [['unit_name'], 'safe'],
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
        $query = Unit::find();

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
            'tenant_id' => $this->tenant_id,
            'property_id' => $this->property_id,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted' => $this->deleted,
            'deleted_at' => $this->deleted_at,
            'deleted_by' => $this->deleted_by,
        ]);

        $query->andFilterWhere(['like', 'unit_name', $this->unit_name]);

        return $dataProvider;
    }
}
