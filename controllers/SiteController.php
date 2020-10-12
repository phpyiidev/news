<?php

namespace app\controllers;

use Yii;
use app\components\BaseController;

/**
 * Контроллер информационных страниц сайта.
 */
class SiteController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Вывод главной страницы сайта.
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
