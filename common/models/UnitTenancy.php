<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit_tenancy".
 *
 * @property int $id
 * @property int $unit_id
 * @property int $tenant_id
 * @property string $move_in_date
 * @property string|null $move_out_date
 * @property int|null $is_active
 * @property string|null $notes
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property Tenant $tenant
 * @property Unit $unit
 */
class UnitTenancy extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unit_tenancy';
    }

    public function behaviors()
    {
        return [
            \yii\behaviors\BlameableBehavior::class,
            \yii\behaviors\TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['move_out_date','notes', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'default', 'value' => null],
            [['unit_id', 'tenant_id', 'move_in_date'], 'required'],
            [['unit_id', 'tenant_id', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['move_in_date', 'move_out_date'], 'safe'],
            [['tenant_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tenant::class, 'targetAttribute' => ['tenant_id' => 'id']],
            [['unit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Unit::class, 'targetAttribute' => ['unit_id' => 'id']],
        
            // move_out_date must be after move_in_date
            ['move_out_date', 'compare', 'compareAttribute' => 'move_in_date', 'operator' => '>=',
                'type' => 'date',
                'when' => fn($model) => !empty($model->move_out_date),
                'message' => 'Move out date must be on or after move in date',
            ],

            // is_active default and range
            ['is_active', 'default', 'value' => 1],
            ['is_active', 'in', 'range' => [0, 1]],

            // Notes
            ['notes', 'string', 'max' => 500],
            ['notes', 'default', 'value' => null],

            // Enforce only one active tenancy per unit at application level
            [
                'unit_id',
                'validateUniqueActiveUnit',
                'when' => fn($model) => $model->is_active == 1,
            ],
        ];
    }

    /**
     * Validate that there is only one active tenancy per unit
     */
    public function validateUniqueActiveUnit($attribute, $params): void
    {
       $query = self::find()
                ->where([
                    'unit_id' => $this->unit_id,
                    'is_active' => 1,
                ]);
        // Exclude current record when updating
        if (!$this->isNewRecord) {
            $query->andWhere(['!=', 'id', $this->id]); // <> id
        }
        
        if ($query->exists()) {
            $this->addError($attribute, 'This unit already has an active tenancy.'. ($this?->tenant?->name ?? ''));
        }
    }   

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'unit_id' => 'Unit ID',
            'tenant_id' => 'Tenant ID',
            'move_in_date' => 'Move In Date',
            'move_out_date' => 'Move Out Date',
            'is_active' => 'Is Active',
            'notes' => 'Notes',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Tenant]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::class, ['id' => 'tenant_id']);
    }

    /**
     * Gets query for [[Unit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUnit()
    {
        return $this->hasOne(Unit::class, ['id' => 'unit_id']);
    }

    /**
     * SCOPES
     */

    // Active Tenancies
    public function findActive(): \yii\db\ActiveQuery
    {
        return $this->andWhere(['is_active' => 1]);
    }

    // Returns Currect Active Tenancy for a given Unit or null if vacant
    public function findActiveByUnit(int $unitId): ?self
    {
        return $this->active()->andWhere(['unit_id' => $unitId])->one();
    }
    
     /**
     * Returns full tenancy history for a unit (newest first).
     */
    public static function findHistoryByUnit(int $unitId): array
    {
        return self::find()
            ->where(['unit_id' => $unitId])
            ->orderBy(['move_in_date' => SORT_DESC])
            ->all();
    }

    /**
     * Returns full tenancy history for a tenant (newest first).
     */
    public static function findHistoryByTenant(int $tenantId): array
    {
        return self::find()
            ->where(['tenant_id' => $tenantId])
            ->orderBy(['move_in_date' => SORT_DESC])
            ->all();
    }

     // -------------------------------------------------------------------------
    // Business Logic
    // -------------------------------------------------------------------------

    /**
     * Moves a tenant into a unit.
     * Fails if the unit already has an active tenancy.
     */
    public static function moveIn(int $unitId, int $tenantId, string $moveInDate, ?string $notes = null): self
    {
        $tenancy = new self([
            'unit_id'      => $unitId,
            'tenant_id'    => $tenantId,
            'move_in_date' => $moveInDate,
            'is_active'    => 1,
            'notes'        => $notes,
        ]);

        if (!$tenancy->save()) {
            throw new \RuntimeException(
                'Move-in failed: ' . implode(', ', $tenancy->getFirstErrors())
            );
        }

        return $tenancy;
    }

     /**
     * Closes this tenancy (move-out).
     */
    public function moveOut(string $moveOutDate, ?string $notes = null): bool
    {
        $this->is_active     = 0;
        $this->move_out_date = $moveOutDate;

        if ($notes !== null) {
            $this->notes = $notes;
        }

        return $this->save();
    }

     /**
     * Transfers a tenant from their current unit to a new unit in one transaction.
     */
    public static function transfer(int $tenantId, int $newUnitId, string $transferDate, ?string $notes = null): self
    {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Close the current active tenancy for this tenant
            $current = self::find()
                ->where(['tenant_id' => $tenantId, 'is_active' => 1])
                ->one();

            if ($current) {
                $current->moveOut($transferDate, 'Transferred to unit ID: ' . $newUnitId);
            }

            // Open new tenancy on the target unit
            $newTenancy = self::moveIn($newUnitId, $tenantId, $transferDate, $notes);

            $transaction->commit();

            return $newTenancy;

        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public function getDurationDays(): int
    {
        $start = strtotime($this->move_in_date);
        $end   = $this->move_out_date ? strtotime($this->move_out_date) : time();
        return (int) floor(($end - $start) / 86400);
    }

    public function getDurationMonths(): float
    {
        $days = $this->getDurationDays();
        return round($days / 30.44, 2); // Average days per month
    }

    public function getDurationYears(): float
    {
        $days = $this->getDurationDays();
        return round($days / 365.25, 2); // Average days per year
    }

    public function getDurationFormatted(): string
    {
        $days = $this->getDurationDays();
        $months = $this->getDurationMonths();
        $years = $this->getDurationYears();
        
        if ($years >= 1) {
            return $years . ' year' . ($years > 1 ? 's' : '') . ' ' . $months . ' month' . ($months > 1 ? 's' : '');
        } elseif ($months >= 1) {
            return $months . ' month' . ($months > 1 ? 's' : '') . ' ' . $days . ' day' . ($days > 1 ? 's' : '');
        } else {
            return $days . ' day' . ($days > 1 ? 's' : '');
        }
    }

    

}
