<?php

namespace frontend\modules\op\controllers;

use Yii;
use frontend\modules\op\models\OpPlanestarifa;
use frontend\modules\op\models\OpPlanestarifaSearch;
use frontend\controllers\base\baseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\h;
use frontend\modules\op\models\OpTarifaHombre;
/**
 * ConfController implements the CRUD actions for OpPlanestarifa model.
 */
class ConfController extends baseController
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
     * Lists all OpPlanestarifa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OpPlanestarifaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OpPlanestarifa model.
     * @param integer $id
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
     * Creates a new OpPlanestarifa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OpPlanestarifa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OpPlanestarifa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing OpPlanestarifa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OpPlanestarifa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OpPlanestarifa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OpPlanestarifa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
     public function actionCreaTarifaHombre()
    {
        $model = new OpTarifaHombre();
   if (h::request()->isAjax && $model->load(h::request()->post())) {
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            
            return \yii\widgets\ActiveForm::validate($model);
          }else{
            
          }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $sesion=h::session();
            $sesion->setFlash('success', yii::t('base.labels','Se actualizó tarifa'));
            return $this->redirect(['/masters/trabajadores', 'id' => $model->id]);
        }

        return $this->render('crea_tarifa', [
            'model' => $model,
        ]);
    }
    
    
    public function actionEditaTarifaHombre($id)
    {
        $model = OpTarifaHombre::findOne($id);
          if (h::request()->isAjax && $model->load(h::request()->post())) {
             h::response()->format = \yii\web\Response::FORMAT_JSON;
            
            return \yii\widgets\ActiveForm::validate($model);
          }else{
            
          }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $sesion=h::session();
            $sesion->setFlash('success', yii::t('base.labels','Se actualizó tarifa'));
            return $this->redirect(['/masters/trabajadores', 'id' => $model->id]);
        }

        return $this->render('update_tarifa', [
            'model' => $model,
        ]);
    }
    
     public function actionViewTarifa($id)
    {
        $model = OpTarifaHombre::findOne($id);

        return $this->render('view_tarifa', [
            'model' => $model,
        ]);
    }
}
