<?php
// Класс автоматически сгенерирован шаблонами giiant. Внесены необходимые правки в сгенерированный код.

namespace app\controllers\base;

use app\models\News;
use app\models\search\NewsSearch;
use app\components\BaseController;
use yii\web\HttpException;
use yii\helpers\Url;

/**
 * NewsController - базовый контроллер новостей, содержит набор действий CRUD для модели News.
 */
class NewsController extends BaseController
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    /**
     * Вывод списка всех новостей.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch;
        $dataProvider = $searchModel->search($_GET);

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Просмотр данных одной новости.
     * @param integer $id Идентификатор просматриваемой новости
     * @return mixed
     */
    public function actionView($id)
    {
        \Yii::$app->session['__crudReturnUrl'] = Url::previous();
        Url::remember();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Создание новости.
     * После успешного создания новости происходит переадресация на страницу просмотра
     * данных о новости, либо на предыдущую страницу.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News;
        $model->load(\Yii::$app->request->get());
        $relAttributes = $model->attributes;

        try {
            if ($model->load(\Yii::$app->request->post()) && $model->save()) {
                //print_r($model);exit;
                if ($relAttributes) {
                    return $this->goBack();
                }
                return $this->redirect(['view', 'id' => $model->id]);
            } elseif (!\Yii::$app->request->isPost) {
                $model->load($_GET);
            }
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            $model->addError('_exception', $msg);
        }

        return $this->render('create', [
            'model' => $model,
            'relAttributes' => $relAttributes,
        ]);
    }

    /**
     * Изменение новости.
     * После успешного изменения новости происходит переадресация на страницу просмотра.
     * @param integer $id Идентификатор изменяемой новости
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new News;
        $model->load($_GET);
        $relAttributes = $model->attributes;

        $model = $this->findModel($id);

        if ($model->load($_POST) && $model->save()) {
            return $this->redirect(Url::previous());
        } else {
            return $this->render('update', [
                'model' => $model,
                'relAttributes' => $relAttributes
            ]);
        }
    }

    /**
     * Удаление новости
     * @param integer $id Идентификатор удаляемой новости
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->findModel($id)->delete();
        } catch (\Exception $e) {
            $msg = (isset($e->errorInfo[2])) ? $e->errorInfo[2] : $e->getMessage();
            \Yii::$app->getSession()->addFlash('error', $msg);
            return $this->redirect(Url::previous());
        }

        $model = new News;
        $model->load($_GET);
        $relAttributes = $model->attributes;
        if ($relAttributes) {
            return $this->redirect(Url::previous());
        }

        // TODO: improve detection
        $isPivot = strstr('$id', ',');
        if ($isPivot == true) {
            return $this->redirect(Url::previous());
        } elseif (isset(\Yii::$app->session['__crudReturnUrl']) && \Yii::$app->session['__crudReturnUrl'] != '/') {
            Url::remember(null);
            $url = \Yii::$app->session['__crudReturnUrl'];
            \Yii::$app->session['__crudReturnUrl'] = null;

            return $this->redirect($url);
        } else {
            return $this->redirect(['index']);
        }
    }

    /**
     * Функция поиска новости по идентификатору
     * Если новости не существует, то вернёт 404 ошибку.
     * @param integer $id Идентификатор искомой новости
     * @return News Модель новости
     * @throws HttpException если не найдена новость
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'The requested page does not exist.');
        }
    }
}
