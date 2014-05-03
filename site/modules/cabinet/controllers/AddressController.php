<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\cabinet\controllers;

use yashop\common\models\search\AddressSearch;
use Yii;
use yii\filters\AccessControl;
use yashop\common\models\user\Address;

use yashop\site\modules\cabinet\CabinetController;
use yii\web\NotFoundHttpException;

class AddressController extends CabinetController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','add','edit','remove'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * List of user addresses
     */
    public function actionIndex()
    {
        $searchModel = new AddressSearch();
        $params = [
            'AddressSearch' => [
                'user_id' => Yii::$app->user->getId(),
                'is_hidden' => 0
            ]
        ];
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'data' => $dataProvider
        ]);
    }

    /**
     * Adding new user address
     */
    public function actionAdd()
    {
        $count = Address::getCountByUser(Yii::$app->user->getId());

        $maxAddress = Address::getMaxPerUser();
        if($count >= $maxAddress)
        {
            Yii::$app->session->setFlash('warning',
                Yii::t('address','Address limit is reached. Limit: {count} addresses',['count'=>$maxAddress]));
            return $this->redirect(['/cabinet/profile/address']);
        }
        return $this->_form();
    }

    /**
     * Editing user address
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionEdit($id)
    {
        return $this->_form($id);
    }

    public function actionRemove($id)
    {
        $model = $this->_getModel($id);
        /*
         * @todo: check address for orders
         */
        $model->delete();

        return $this->redirect(['/cabinet/profile/address']);
    }

    /**
     * Rendering address edit form
     * @param bool $id Address id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    private function _form($id = false)
    {
        $oldAddress = false;
        if($id)
        {
            $address = $this->_getModel($id);
            /*
             * @todo: check address for orders
            if(!empty($address->orders))
            {
                $oldAddress = $address;
                $address = new Address;
            }
            */
        } else {
            $address = new Address;
        }

        if($address->load(Yii::$app->request->post())) {

            $address->user_id = Yii::$app->user->getId();
            if($address->validate()) {
                if($oldAddress) {
                    $oldAddress->is_hidden = 1;
                    $oldAddress->save();
                }
                $address->save();
                Yii::$app->session->setFlash('success','Адрес успешно сохранен');

                return $this->redirect(['/cabinet/profile/address']);
            }
        }

        return $this->render('form',array('model'=>$address));
    }

    /**
     * @param $id
     * @return static
     * @throws \yii\web\NotFoundHttpException
     */
    private function _getModel($id)
    {
        $address = Address::findOne($id);

        if(!$address || $address->user_id !== Yii::$app->user->getId())
            throw new NotFoundHttpException(Yii::t('yii','The requested page does not exist.'));

        return $address;
    }
}