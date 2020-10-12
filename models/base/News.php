<?php
// Класс автоматически сгенерирован шаблонами giiant. Внесены необходимые правки в сгенерированный код.

namespace app\models\base;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * Класс базовой модели для таблицы "news".
 *
 * @property integer $id Идентификационный код записи
 * @property string $name Заголовок новости
 * @property integer $text Текст новости
 * @property integer $created_by Время создания
 * @property integer $updated_by Время изменения
 * @property integer $created_at Кем создана
 * @property integer $updated_at Кем изменена
 *
 * @property null|integer[]|\app\models\Rubrics[] $rubrics Связь с рубриками.
 */
abstract class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            // Поведение для сохранения информации о пользователе создавшим/изменившим запись
            ['class' => BlameableBehavior::className(),],
            // Поведение для сохранение времени создания/изменения записи
            ['class' => TimestampBehavior::className(),],
            // Поведение для упрощения взаимодействия со связью "многие ко многим", при сохранении/просмотре/изменении/удалении
            'saveRelations' => [
                'class'     => SaveRelationsBehavior::className(),
                'relations' => [
                    'rubrics',
                ],
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 42],
            [['rubrics'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Код',
            'name' => 'Заголовок',
            'text' => 'Текст',
            'rubrics' => 'Рубрики',
            'created_by' => 'Создал',
            'updated_by' => 'Изменил',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubrics()
    {
        return $this->hasMany(\app\models\Rubrics::className(), ['id' => 'id_rubric'])->viaTable('{{%news_rubrics}}', ['id_new' => 'id']);
    }
}
