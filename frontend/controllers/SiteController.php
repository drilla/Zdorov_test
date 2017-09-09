<?php
namespace frontend\controllers;

use Frontend\models\OrderForm;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;

class SiteController extends Controller
{
    public function actions() { return ['error' => ['class' => ErrorAction::class]]; }

    public function actionIndex() {
        return $this->render('index');
    }

    /**
     * валидания/создание новой заявки
     */
    public function actionCreate() {
        $request = Yii::$app->request;

        $order = new OrderForm();
        $order->load($request->post());

        /**
         * провалидируем форму, если она пришла аяксом и отправим ответ
         */
        if ($request->getIsAjax()) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($order);
        } else {

            /**
             * Форма должна быть проавлидирована, если это не так значит возможно данные формы изменились.
             */
            if (!$order->validate()) {
                throw new BadRequestHttpException('Переданы неправильные данные формы.');
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
