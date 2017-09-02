<?php
namespace frontend\controllers;

use frontend\models\ProductRequest;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;

class SiteController extends Controller
{
    public function behaviors() {
        return [
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'create-product-request' => ['post'],
//                ],
//            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * валидания и создание новой заявки
     */
    public function actionCreate() {
        $request = Yii::$app->request;

        $newProductRequest = new ProductRequest();
        $newProductRequest->setScenario(ProductRequest::SCENARIO_CREATE);
        $newProductRequest->load($request->post());
        /**
         * провалидируем форму, если она пришла аяксом и отправим ответ
         */
        if ($request->getIsAjax()) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($newProductRequest);
        } else {

            /**
             * Форма должна быть проавлидирована, если это не так значит возможно данные формы изменились.
             */
            if (!$newProductRequest->validate()) {
                throw new BadRequestHttpException(var_export($newProductRequest, true) .  'Переданы неправильные данные формы.');
            }

            return $this->redirect('success');
        }
    }

    /**
     * страница, показываемая в случае успешного добавления заявки
     */
    public function actionSuccess() {
        return $this->render('success');
    }
}
