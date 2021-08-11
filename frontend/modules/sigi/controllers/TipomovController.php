<?php

namespace frontend\modules\sigi\controllers;

use Yii;
use frontend\modules\sigi\models\SigiTipomov;
use frontend\modules\sigi\models\SigiTipomovSearch;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use yii\helpers\Url;
use frontend\controllers\base\baseController;
use yii\web\Response;
use yii\widgets\ActiveForm;
/**
 * TipomovController implements the CRUD actions for SigiTipomov model.
 */
class TipomovController extends baseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SigiTipomov models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SigiTipomovSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SigiTipomov model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SigiTipomov model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SigiTipomov();
        
        
        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', /*'id' => $model->codigo*/]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SigiTipomov model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (h::request()->isAjax && $model->load(h::request()->post())) {
                h::response()->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', /*'id' => $model->codigo*/]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SigiTipomov model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SigiTipomov model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SigiTipomov the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SigiTipomov::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('sigi.labels', 'The requested page does not exist.'));
    }
}
