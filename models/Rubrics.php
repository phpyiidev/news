<?php

namespace app\models;

use Yii;
use \app\models\base\Rubrics as BaseRubrics;
use yii\helpers\ArrayHelper;

/**
 * Класс модели рубрик для таблицы "rubrics". Наследует базовую модель. Содержит дополнительные функции для работы с
 * данными модели
 */
class Rubrics extends BaseRubrics
{
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }

    /**
     * Выводит список всех рубрик по указанным полям
     * @param string $keyField Ключевое поле
     * @param string $valueField Поле значения
     * @param bool $asArray В виде массива
     * @return array
     */
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }

    /**
     * Получение массива всех рубрик с подрубриками, вида
     * [
     *      'id рубрики1' => [{модель подрубрики1 Rubrics},{модель подрубрики2 Rubrics},...],
     *      'id рубрики2' => [{модель подрубрики3 Rubrics},{модель подрубрики4 Rubrics},...],...
     * ]
     * для каждой рубрики.
     * Массив нужен для последующего построения дерева
     * @return array|null
     */
    public static function getSubRubricsArray() {
        $rubrics = static::find()->all();
        if (empty($rubrics)) {
            return null;
        }
        $subRubricsArr = [];
        /** @var Rubrics[] $rubrics */
        foreach ($rubrics as $rubric) {
            $id_parent = is_null($rubric->id_parent) ? 0 : $rubric->id_parent;
            if (empty($subRubricsArr[$id_parent])) {
                $subRubricsArr[$id_parent] = [];
            }
            $subRubricsArr[$id_parent][] = $rubric;
        }
        return $subRubricsArr;
    }

    /**
     * Рекурсионная функция, возвращающая дерево рубрик с подрубриками, собраное из массива вида
     * [
     *      'id рубрики1' => [{модель подрубрики1 Rubrics},{модель подрубрики2 Rubrics},...],
     *      'id рубрики2' => [{модель подрубрики3 Rubrics},{модель подрубрики4 Rubrics},...],...
     * ]
     * @param array $subRubricsArr массив рубрик с подрубриками (как указано выше)
     * @param array $out Возвращаемый результат (ссылка для сохранения данных в процессе рекурсии)
     * @param int $id_parent Идентификатор родительской рубрики. Дерево начинается с подрубрик указанной рубрики.
     *                          Для начала дерева с корневых рубрик, родительский идентификатор равен 0
     * @return mixed
     */
    public static function getRubricsTree($subRubricsArr, &$out, $id_parent = 0)
    {
        if (empty($subRubricsArr[$id_parent])) {
            return $out;
        }
        /** @var Rubrics $rubric */
        foreach ($subRubricsArr[$id_parent] as $rubric) {
            $items[$rubric->id] = [
                'id' => $rubric->id,
                'name' => $rubric->name,
                'id_parent' => is_null($rubric->id_parent) ? 0 : $rubric->id_parent,
                'items' => []
            ];
            self::getRubricsTree($subRubricsArr, $items, $rubric->id);
            $out[$id_parent]['items'] = $items;
        }
        return $out;
    }

    /**
     * Рекурсионная функция, формирует список рубрик с подрубриками в заданом виде.
     * Массив в виде списка (type=list):
     * [
     * 'id рубрики1' => 'name рубрики1',
     * 'id подрубрики1' => '- name подрубрики1',
     * 'id подподрубрики1' => '- - name подподрубрики1',
     * 'id рубрики2' => 'name рубрики2',...
     * ]
     * Массив объектов (type=list):
     * [0=>{рубрика1 Rubrics},1=>{подрубрика1 Rubrics},2=>{подподрубрика1 Rubrics},3=>{рубрика2 Rubrics},...]
     * @param array $out Возвращаемый результат (ссылка для сохранения данных в процессе рекурсии)
     * @param int|null $id Идентификатор родительской рубрики. Массив начинается с подрубрик указанной рубрики.
     *                          Для начала массива с корневых рубрик, родительский идентификатор равен null
     * @param int $level Глубина подрубрики - необходима для определения количества дифисов в префиксе
     * @param string $type Тип выдаваемого результата ('list'|'array')
     * @return array
     */
    public static function listAllFormatted(&$out, $id = null, &$level = 0, $type = "list")
    {
        $rubrics = static::findAll(['id_parent' => $id]);
        foreach ($rubrics as $model) {
            $prefix = "";
            for ($c=0;$c<$level;$c++) {
                $prefix .= "- ";
            }
            $level++;
            static::listAllFormatted($out, $model->id, $level);
            $level--;
            if ($type == "list") {
                $out[$model->id] = $prefix.$model->name;
            } elseif ($type == "array") {
                array_push($out,$model);
            }
        }
        // Так как рекурсия вернет рубрики в обратной последовательности - переворачиваем массив
        return array_reverse($out,true);
    }

    /**
     * Рекурсионная функция возвращающая массив идентификаторов всех подрубрик для указанных рубрик,
     * включая идентификаторы рубрик
     * @param array $out Возвращаемый результат (ссылка для сохранения данных в процессе рекурсии)
     * @param array|int $ids Массив идентификаторов рубрик, либо один идентификатор рубрики
     * @return array
     */
    public static function getSubRubricsId(&$out, $ids)
    {
        $subRubrics = static::find()->where(['in','id_parent', $ids])->all();
        array_push($out,(int)$ids);
        foreach ($subRubrics as $model) {
            static::getSubRubricsId($out, $model->id);
            if (!in_array($model->id,$out)) {
                array_push($out,$model->id);
            }
        }
        return $out;
    }
}
