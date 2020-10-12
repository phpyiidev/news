<?php

namespace app\models;

use Yii;
use \app\models\base\News as BaseNews;
use yii\helpers\ArrayHelper;

/**
 * Класс модели новостей для таблицы "news". Наследует базовую модель. Содержит дополнительные функции для работы с
 * данными модели
 */
class News extends BaseNews
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
     * Выводит список всех новостей по указанным полям
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
}
