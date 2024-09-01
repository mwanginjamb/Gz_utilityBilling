<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Paymentheader;

/**
 * PaymentheaderSearch represents the model behind the search form of `common\models\Paymentheader`.
 */
class PaymentheaderSearch extends Paymentheader
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'payperiod_id', 'property_id', 'created_at', 'update_at', 'created_by', 'updated_by'], 'integer'],
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
        $query = Paymentheader::find();

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
            'payperiod_id' => $this->payperiod_id,
            'property_id' => $this->property_id,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        return $dataProvider;
    }
}
