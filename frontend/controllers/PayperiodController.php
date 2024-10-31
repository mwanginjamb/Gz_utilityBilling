<?php

namespace frontend\controllers;

use common\models\Paymentheader;
use common\models\Payperiodstatus;
use yii\web\Controller;
use common\models\Property;
use yii\filters\VerbFilter;
use common\models\Payperiod;
use yii\helpers\ArrayHelper;
use common\models\PayperiodSearch;
use yii\web\NotFoundHttpException;

/**
 * PayperiodController implements the CRUD actions for Payperiod model.
 */
class PayperiodController extends Controller
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
                        'generate-header' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Payperiod models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PayperiodSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Payperiod model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'paymentheader' => Paymentheader::find()->joinWith('paymentlines')->where(['payperiod_id' => $model->id, 'property_id' => $model->property_id])->asArray()->one(),
        ]);
    }

    /**
     * Creates a new Payperiod model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Payperiod();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'properties' => ArrayHelper::map(Property::find()->all(), 'id', 'name')
        ]);
    }

    /**
     * Updates an existing Payperiod model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', 'Record Saved Successfully.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'properties' => ArrayHelper::map(Property::find()->all(), 'id', 'name'),
            'payperiodstatus' => ArrayHelper::map(Payperiodstatus::find()->all(), 'id', 'name')
        ]);
    }

    /**
     * Deletes an existing Payperiod model.
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

    public function actionGenerateHeader()
    {

        $paymentHeader = new Paymentheader();
        $paymentHeader->payperiod_id = \Yii::$app->request->post('payperiod');
        $paymentHeader->property_id = \Yii::$app->request->post('property');

        if ($paymentHeader->save()) {
            \Yii::$app->session->setFlash('success', 'Payment Header for this property and period has been created.');
        } else {
            \Yii::$app->session->setFlash('error', 'Could not create a payperiod payment header.');
        }
        return $this->redirect(['view', 'id' => \Yii::$app->request->post('payperiod')]);
    }

    /**
     * Finds the Payperiod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Payperiod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payperiod::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
