<?php
namespace backend\controllers;

use common\models\Product;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    ['actions' => ['list', 'edit', 'toggle-state'], 'allow' => true, 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'toggle-state' => ['post'],
                ],
            ],
        ];
    }

    public function actionList() {
        return $this->render('list', [
            'products' => Product::find()->all()
        ]);
    }

    /**
     * Активация / деактивация товара
     */
    public function actionToggleState(int $id) {

        $product = Product::findById($id);

        if (!$product) throw new NotFoundHttpException('Этот товар не найден');

        $product->toggleStatus();

        if (!$product->save()) {
            throw new \Exception(var_export($product->getErrors(), true));
        }

        $this->redirect(Url::toRoute('product/list'));
    }
}