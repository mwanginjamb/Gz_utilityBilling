<?php

namespace frontend\controllers;

use Yii;
use common\models\Unit;
use yii\web\Controller;
use yii\httpclient\Client;
use common\models\Property;
use common\models\Schedule;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\models\PropertySearch;
use yii\httpclient\CurlTransport;
use yii\filters\ContentNegotiator;
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
                'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['logout', 'index', 'update', 'view', 'create'],
                    'rules' => [
                        [
                            'actions' => ['logout', 'index', 'update', 'view', 'delete', 'create'],
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'contentNegotiator' => [
                    'class' => ContentNegotiator::class,
                    'only' => ['commit'],
                    'formatParam' => '_format',
                    'formats' => [
                        'application/json' => \yii\web\Response::FORMAT_JSON,
                    ]
                ],
            ]
        );
    }


    public function beforeAction($action)
    {

        $ExceptedActions = [
            'commit',
        ];

        if (in_array($action->id, $ExceptedActions)) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
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
        $user = Yii::$app->user->id;
        $properties = Property::find()->where(['or', ['created_by' => $user], ['updated_by' => $user]])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $properties,

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

        //Yii::$app->utility->printrr($vacantUnits);

        $totalTenants = count($occupiedUnits);
        $totalVacant = count($vacantUnits);

        if (is_array($occupiedUnits) && count($occupiedUnits)) {
            $totalRevenue = array_reduce($occupiedUnits, function ($total, $unit) {
                return $total + $unit['tenant']['agreed_rent_payable'];
            }, 0);
        }

        $schedule = Schedule::find()->where(['estate_id' => $id])->one();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'occupiedUnits' => $occupiedUnits,
            'totalTenants' => $totalTenants,
            'totalVacant' => $totalVacant,
            'totalRevenue' => $totalRevenue,
            'vacantUnits' => $vacantUnits,
            'schedule' => $schedule
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

    public function actionSchedule()
    {
        $property = Yii::$app->request->post('property');
        $schedule = new Schedule();
        $schedule->estate_id = $property;
        if ($schedule->save()) {
            Yii::$app->session->setFlash('success', 'A scheduling for billing has been created, please adjust the billing date from the scheduling table.');
        } else {
            Yii::$app->session->setFlash('error', 'Could not create a scheduled billing schedule, contact the administrator.');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCommit()
    {
        try {
            $endpoint = Yii::$app->request->post('service');
            $field = Yii::$app->request->post('name');
            $value = Yii::$app->request->post('value');

            $payload = [
                $field => $value
            ];

            $client = new Client([
                'transport' => CurlTransport::class,
            ]);

            $request = $client->createRequest()
                ->setMethod('PUT')
                ->setUrl($endpoint)
                ->addHeaders(['Content-Type' => 'application/json'])
                ->setFormat(Client::FORMAT_JSON)  // Ensures JSON encoding
                ->setData($payload)
                ->setOptions([
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false
                ]);

            $response = $request->send();

            if ($response->isOk) { // Check if the response status is 200-299
                return $response->data; // Return the relevant response data
            } else {
                // Log error details if needed and return a clear message
                return [
                    'status' => $response->statusCode,
                    'error' => $response->data ?? 'Unexpected error occurred'
                ];
            }
        } catch (\Exception $e) {
            return "HTTP request failed with error: " . $e->getMessage();
        }

    }
}
