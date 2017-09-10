<?php
namespace frontend\controllers;

use common\models\Order;
use common\models\Product;
use frontend\models\OrderForm;
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

        $orderForm = new OrderForm();
        $orderForm->load($request->post());

        /**
         * провалидируем форму, если она пришла аяксом и отправим ответ
         */
        if ($request->getIsAjax()) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($orderForm);
        } else {

            /**
             * Форма должна быть проавлидирована, если это не так значит возможно данные формы изменились
             */
            if (!$orderForm->validate()) {
                throw new BadRequestHttpException('Переданы неправильные данные формы');
            }

            $product = Product::findById($orderForm->product_id);
            if (!$product) {
                throw new \Exception('Продукт не найден');
            }

            $order = Order::createByForm($orderForm);

            if (!$order->save()) {
                throw new \Exception('Заказ создать не удалось');
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
