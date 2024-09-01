<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Payperiod;

/**
 * PayperiodSearch represents the model behind the search form of `common\models\Payperiod`.
 */
class PayperiodSearch extends Payperiod
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'property_id', 'payperiodstatus_id', 'created_at', 'update_at', 'created_by', 'updated_by'], 'integer'],
            [['period', 'body'], 'safe'],
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
        $query = Payperiod::find();

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
            'period' => $this->period,
            'property_id' => $this->property_id,
            'payperiodstatus_id' => $this->payperiodstatus_id,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
