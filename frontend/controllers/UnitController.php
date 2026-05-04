<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\Unit;
use yii\web\Controller;
use common\models\Tenant;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\UnitSearch;
use common\models\ExcelImport;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends Controller
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
            ]
        );
    }

    /**
     * Lists all Unit models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unit model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Unit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($property = null)
    {
        $model = new Unit();
        $property_initiated = false;
        if ($property) {
            $model->property_id = $property;
            $property_initiated = true;
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                if ($property_initiated) {
                    return $this->redirect(Url::toRoute(['property/view', 'id' => $property], $schema = true));
                }
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
     * Updates an existing Unit model.
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
     * Deletes an existing Unit model.
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
     * Finds the Unit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Unit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unit::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    /** Excel import functions */

    public function actionExcelImport($property)
    {
        $model = new ExcelImport();
        $model->property_id = $property;
        return $this->render('import', ['model' => $model]);
    }

    public function actionImport()
    {
        $model = new ExcelImport();
        if ($model->load(Yii::$app->request->post())) {
            $excelUpload = UploadedFile::getInstance($model, 'excel_doc');
            $model->excel_doc = $excelUpload;
            if ($uploadedFile = $model->upload()) {
                // Extract data from  uploaded file
                $sheetData = $this->extractData($uploadedFile);
                unlink($uploadedFile);
                // save the data
                $this->saveData($sheetData, $model->property_id);
            } else {
                return $this->redirect(['excel-import']);
            }
        } else {
            return $this->redirect(['excel-import']);
        }
    }

    private function extractData($file)
    {
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        return $sheetData;
    }

    private function saveData($sheetData, $property_id)
    {

        $existingUnits = ArrayHelper::index(Unit::find()->select(['id'])->where(['property_id' => $property_id])->AsArray()->all(), 'id');
        $existing = array_unique(array_keys($existingUnits));

        $rowOffset = 1;

        $filteredArray = array_filter($sheetData, function ($item) use ($existing) {
            return !in_array($item['A'], $existing) && !is_null($item['A']);
        });

        // Check for property consistency
        if ($property_id !== $filteredArray[1]['B']) {
            Yii::$app->session->setFlash('error', 'Your template property id is not consistent with that of property (' . $property_id . ')  whose units you are importing.');
            return $this->redirect(Url::toRoute(['property/view', 'id' => $property_id]));
        }

        foreach ($filteredArray as $key => $data) {
            // Read from 3rd row
            if ($key > 3) {
                // Yii::$app->utility->printrr($filteredArray[$key]['A']);
                if (!is_null($data['A'])) {
                    /**
                     * Save the units
                     */
                    $model = new Unit();
                    $model->unit_name = $data['A'] ?? '';
                    $model->property_id = $filteredArray[1]['B'];


                    if (!$model->save()) {
                        foreach ($model->errors as $k => $v) {
                            Yii::error('Unit Commit error: ' . $v[0] . ' <b>Got value</b>: <i><u>' . $model->$k . '</u> <b>for Unit:' . $data['A'] . '</b> - On Row:</b>  ' . ($key - $rowOffset) . '  ' . $data['A'], 'dbinfo');
                            Yii::$app->session->setFlash('error', $v[0] . ' <b>Got value</b>: <i><u>' . $model->$k . '</u> <b>for Unit:' . $data['C'] . '</b> - On Row:</b>  ' . ($key - $rowOffset) . '  ' . $data['A']);
                        }
                    } else {
                        // Save tenants
                        $tenant = new Tenant();
                        $tenant->principle_tenant_name = $data['B'] ?? '';
                        $tenant->billing_email_address = str_replace(' ', '', $data['C']) ?? '';
                        $tenant->agreed_rent_payable = $data['D'] ?? 0;
                        $tenant->agreed_water_rate = $data['E'] ?? 0;
                        $tenant->service_charge = $data['F'] ?? 0;
                        $tenant->house_number = $model->id;
                        $tenant->cell_number = $data['G'] ?? '';
                        if (!$tenant->save()) {
                            foreach ($tenant->errors as $k => $v) {
                                Yii::error('Tenant saving error: ' . $v[0] . ' <b>Got value</b>: <i><u>' . $tenant->$k . '</u>', 'dbinfo');
                            }
                        } else {
                            // Move in the tenant
                            \common\models\UnitTenancy::moveIn($model->id, $tenant->id, date('Y-m-d'),'Moved in during import');
                            Yii::info('Imported tenant' . VarDumper::dumpAsString($tenant), 'dbinfo');
                        }
                        Yii::$app->session->setFlash('success', 'Congratulations, all valid records are completely imported into the system.');
                    }
                }
            }
            if (count($existing)) {
                Yii::$app->session->setFlash('error', count($existing) . ' duplication conflicts were found on your import.');
            }
        }


        return $this->redirect(Url::toRoute(['property/view', 'id' => $model->property_id]));
    }
    public function actionDownload($templateName)
    {
        // Define the path to the template file
        $templateFilePath = Yii::getAlias('@webroot/templates/' . $templateName);

        // Check if the file exists before proceeding
        if (file_exists($templateFilePath)) {
            // Set response headers for file download
            Yii::$app->response->sendFile($templateFilePath, 'template.xlsx', [
                'mimeType' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ]);
        } else {
            // Handle the case where the template file doesn't exist
            Yii::$app->session->setFlash('error', 'Template file not found.');
            // Redirect or display an error message
            Yii::$app->getResponse()->redirect(Yii::$app->request->referrer);
        }
    }

   }
