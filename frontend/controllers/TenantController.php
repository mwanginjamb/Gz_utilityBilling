<?php

namespace frontend\controllers;

use common\models\Paymentlines;
use common\models\Tenant;
use common\models\TenantSearch;
use kartik\mpdf\Pdf;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            'dataProvider' => Tenant::find()->all(),
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
     * Updates an existing Tenant model.
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
}
