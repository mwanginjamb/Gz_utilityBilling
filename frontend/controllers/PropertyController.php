<?php

namespace frontend\controllers;

use common\models\Unit;
use yii\web\Controller;
use common\models\Property;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\PropertySearch;
use yii\web\NotFoundHttpException;

/**
 * PropertyController implements the CRUD actions for Property model.
 */
class PropertyController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Property models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PropertySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Property model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $totalRevenue = 0;

        $occupiedUnits = Unit::find()->joinWith('tenant')
            ->andWhere(['property_id' => $id])
            ->andWhere(['not', ['tenant.id' => NULL]])->asArray()->all();

        $vacantUnits = Unit::find()->joinWith('tenant')
            ->andWhere(['property_id' => $id])
            ->andWhere(['tenant.id' => NULL])->asArray()->all();

        $totalTenants = count($occupiedUnits);
        $totalVacant = count($vacantUnits);

        if (is_array($occupiedUnits) && count($occupiedUnits)) {
            $totalRevenue = array_reduce($occupiedUnits, function ($total, $unit) {
                return $total + $unit['tenant']['agreed_rent_payable'];
            }, 0);
        }


        return $this->render('view', [
            'model' => $this->findModel($id),
            'occupiedUnits' => $occupiedUnits,
            'totalTenants' => $totalTenants,
            'totalVacant' => $totalVacant,
            'totalRevenue' => $totalRevenue
        ]);
    }

    /**
     * Creates a new Property model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Property();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Property model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Property model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Property model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Property the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Property::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
