<?php
// Класс автоматически сгенерирован шаблонами giiant. Внесены необходимые правки в сгенерированный код.

namespace app\controllers\base;

use app\models\Rubrics;
use app\models\search\RubricsSearch;
use app\components\BaseController;
use yii\web\HttpException;
use yii\helpers\Url;

/**
 * RubricsController базовый контроллер рубрик, содержит набор действий CRUD для модели Rubrics.
 */
class RubricsController extends BaseController
{
    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    public $enableCsrfValidation = false;

    /**
     * Вывод списка всех рубрик.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RubricsSearch;
        $dataProvider = $searchModel->search($_GET);

        Url::remember();
        \Yii::$app->session['__crudReturnUrl'] = null;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Просмотр данных одной рубрики.
     * @param integer $id Идентификатор просматриваемой рубрики
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
     * Создание рубрики.
     * После успешного создания рубрики происходит переадресация на страницу просмотра
     * данных о рубрики, либо на предыдущую страницу.
     * @param integer|null $id_parent Идентификатор родительской рубрики. Null для корневых рубрик
     * @return mixed
     */
    public function actionCreate($id_parent = null)
    {
        $model = new Rubrics;
        $model->load($_GET);
        $model->id_parent = $id_parent;
        $relAttributes = $model->attributes;

        try {
            if ($model->load($_POST) && $model->save()) {
                if ($relAttributes) {
                    return $this->goBack();
                }
                return $this->redirect(['index']);
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
     * Изменение информации о рубрики.
     * После успешного изменения рубрики происходит переадресация на страницу просмотра.
     * @param integer $id Идентификатор изменяемой рубрики
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = new Rubrics;
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
     * Удаление рубрики.
     * @param integer $id Идентификатор удаляемой рубрики
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

        $model = new Rubrics;
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
     * Функция поиска рубрики по идентификатору
     * Если рубрики не существует, то вернёт 404 ошибку.
     * @param integer $id Идентификатор искомой рубрики
     * @return Rubrics модель рубрики
     * @throws HttpException если не найдена рубрикиа
     */
    protected function findModel($id)
    {
        if (($model = Rubrics::findOne($id)) !== null) {
            return $model;
        } else {
            throw new HttpException(404, 'Указанная рубрика не существует.');
        }
    }
}
