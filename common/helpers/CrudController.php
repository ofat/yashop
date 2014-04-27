<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace common\helpers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

abstract class CrudController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => $this->getActionsList(),
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $this->redirect(['list']);
    }

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionList()
    {
        $modelName = $this->getSearchModel();
        $searchModel = new $modelName;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays and updates a single model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        } else {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelName = $this->getModel();
        $model = new $modelName;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return \yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelName = $this->getModel();
        if($id == 0)
            return new $modelName;

        if (($model = $modelName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));
        }
    }

    abstract protected function getModel();

    abstract protected function getSearchModel();

    protected function getActionsList()
    {
        return ['index', 'list', 'view','create'];
    }

}