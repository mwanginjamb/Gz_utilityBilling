<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tenant;

/**
 * TenantSearch represents the model behind the search form of `common\models\Tenant`.
 */
class TenantSearch extends Tenant
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'agreed_rent_payable', 'agreed_water_rate', 'has_signed_tenancy_agreement', 'created_at', 'update_at'], 'integer'],
            [['principle_tenant_name', 'house_number', 'cell_number', 'billing_email_address', 'id_number'], 'safe'],
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
        $query = Tenant::find();

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
            'user_id' => $this->user_id,
            'agreed_rent_payable' => $this->agreed_rent_payable,
            'agreed_water_rate' => $this->agreed_water_rate,
            'has_signed_tenancy_agreement' => $this->has_signed_tenancy_agreement,
            'created_at' => $this->created_at,
            'update_at' => $this->update_at,
        ]);

        $query->andFilterWhere(['like', 'principle_tenant_name', $this->principle_tenant_name])
            ->andFilterWhere(['like', 'house_number', $this->house_number])
            ->andFilterWhere(['like', 'cell_number', $this->cell_number])
            ->andFilterWhere(['like', 'billing_email_address', $this->billing_email_address])
            ->andFilterWhere(['like', 'id_number', $this->id_number]);

        return $dataProvider;
    }
}
