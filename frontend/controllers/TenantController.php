<?php

namespace frontend\controllers;

use Yii;
use kartik\mpdf\Pdf;
use common\models\Unit;
use yii\web\Controller;
use common\models\Tenant;
use common\models\Visitor;
use yii\httpclient\Client;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use common\models\Paymentlines;
use common\models\TenantSearch;
use yii\httpclient\CurlTransport;
use yii\filters\ContentNegotiator;
use yii\web\NotFoundHttpException;

/**
 * TenantController implements the CRUD actions for Tenant model.
 */
class TenantController extends Controller
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
     * Lists all Tenant models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TenantSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => 'SORT_DESC'];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => Tenant::find()->joinWith('unit')->where(['not', ['unit.unit_name' => NULL]])->all(),
        ]);
    }

    /**
     * Displays a single Tenant model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'invoices' => Paymentlines::find()->joinWith('tenant')->where(['tenant_id' => $id])->all(),
            'visitors' => Visitor::find()->where(['tenant_id' => $id])->all()
        ]);
    }

    /**
     * Creates a new Tenant model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tenant();
        $units = Unit::find()->where(['property_id' => Yii::$app->request->get('property')])->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'units' => ArrayHelper::map($units, 'id', 'unit_name')
        ]);
    }

    /**
     * Updates an existing Tenant model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $units = Unit::find()->where(['property_id' => Yii::$app->request->get('property')])->all();

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'units' => ArrayHelper::map($units, 'id', 'unit_name')
        ]);
    }

    /**
     * Deletes an existing Tenant model.
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
     * Finds the Tenant model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tenant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tenant::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionViewInvoice($invoiceid)
    {
        $line = Paymentlines::find()
            ->joinwith('paymentheader')
            ->joinWith('tenant')
            ->where(['paymentlines.id' => $invoiceid])
            ->one();


        return $this->renderPartial('_report', [
            'line' => $line
        ]);

    }
    public function actionReport($invoiceid)
    {
        $line = Paymentlines::find()
            ->joinwith('paymentheader')
            ->joinWith('tenant')
            ->where(['paymentlines.id' => $invoiceid])
            ->one();

        $title = 'Rental Invoice';
        $date = 'Generated on ' . date('F j Y H:i:s');

        $content = $this->renderPartial('_invoice_template', [
            'line' => $line
        ]);

        $pdf = \Yii::$app->pdf;
        $pdf->content = $content;
        $pdf->cssFile = './css/invoice.css';
        $pdf->methods = [
            'SetHeader' => [$title],
            'SetFooter' => ['{PAGENO}']
        ];
        $binary = $pdf->render('', 'S');
        $base64Content = chunk_split(base64_encode($binary));
        return $this->render('_invoice', [
            'content' => $base64Content
        ]);

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

    public function actionVisitor()
    {
        $tenant = Yii::$app->request->post('tenant');
        $model = new Visitor();
        $model->tenant_id = $tenant;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Record Created Successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Could not create record at this moment.');
        }

        return $this->redirect(['view', 'id' => $tenant]);
    }
}
