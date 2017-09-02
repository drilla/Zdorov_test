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

    public function actionCreate() {

        $request = Yii::$app->request;

        $newProductRequest = new ProductRequest();

        /**
         * провалидируем форму, если она пришла аяксом и отправим ответ
         */
        if ($request->getIsAjax()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $newProductRequest->load($request->post());

            return ActiveForm::validate($newProductRequest);
        }

        /**
         * Форма должна быть проавлидирована, если это не так значит возможно данные формы изменилить.
         */
        if (!$newProductRequest->validate()) {
            throw new BadRequestHttpException('Переданы неправильные данные формы.');
        }

        return $this->render('success');
    }
}
