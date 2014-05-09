<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\admin\modules\catalog\controllers;

use yashop\admin\models\CategorySearch;
use yashop\common\helpers\CrudController;
use yashop\common\models\category\Category;
use yashop\common\models\category\CategoryDescription;
use yashop\common\models\Language;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * LanguageController implements the CRUD actions for Country model.
 */
class CategoryController extends CrudController
{

    protected function getActionsList()
    {
        return ['index', 'list', 'view', 'create'];
    }

    public function actionCreate()
    {
        return $this->actionView(0);
    }

    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $description = ArrayHelper::index($model->allDescription, 'language_id');
        $languages = Language::getActive();
        foreach($languages as $language)
        {
            if(isset($description[ $language->id ]))
                continue;

            $description[ $language->id ] = new CategoryDescription;
            $description[ $language->id ]->language_id = $language->id;
            $description[ $language->id ]->category_id = $model->id;
        }

        $post = Yii::$app->request->post();
        $categoryLoaded = $model->load($post) && $model->validate();
        $descriptionLoaded = Model::loadMultiple($description, $post);

        if ($categoryLoaded && $descriptionLoaded) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $r = $model->save();
                foreach($description as $item)
                {
                    $item->category_id = $model->id;
                    $r = $item->save() && $r;
                }
                if($r) {
                    $transaction->commit();
                    return $this->redirect(['list']);
                }
                else
                    throw new HttpException(500, Yii::t('base', 'Saving error. Please try again'));
            } catch(Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        } else {
            return $this->render('view', [
                'model' => $model,
                'description' => $description,
                'languages' => $languages
            ]);
        }
    }

    protected function getModel()
    {
        return Category::className();
    }

    protected function getSearchModel()
    {
        return CategorySearch::className();
    }

    protected function findModel($id)
    {
        $modelName = $this->getModel();
        if($id == 0)
            return new $modelName;

        $model = $modelName::find()->where(['id'=>$id])->with('allDescription')->one();
        if ( $model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('base','The requested page does not exist.'));
        }
    }

}